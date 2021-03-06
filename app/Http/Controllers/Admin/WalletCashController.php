<?php



namespace Genv\Otc\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Genv\Otc\Models\WalletCash;
use Illuminate\Support\Facades\DB;
use Genv\Otc\Models\WalletCharge;
use Genv\Otc\Repository\WalletRatio;
use Genv\Otc\Http\Controllers\Controller;

class WalletCashController extends Controller
{
    /**
     * 获取提现列表.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function show(Request $request, WalletRatio $repository)
    {
        $user = $request->query('user');
        $status = $request->query('status');
        $order = $request->query('order', 'desc') === 'asc' ? 'asc' : 'desc';
        $limit = $request->query('limit', 20);

        $query = WalletCash::with('user');

        if ($user) {
            $query->where('user_id', $user);
        }

        if ($status !== null && $status !== 'all') {
            $query->where('status', $status);
        }

        $query->orderBy('id', $order);
        $paginate = $query->paginate($limit);
        $items = $paginate->items();

        if (empty($items)) {
            return response()
                ->json(['message' => ['没有检索到数据']])
                ->setStatusCode(404);
        }

        return response()
            ->json([
                'last_page' => $paginate->lastPage(),
                'current_page' => $paginate->currentPage(),
                'first_page' => 1,
                'cashes' => $items,
                'ratio' => $repository->get(),
            ])
            ->setStatusCode(200);
    }

    /**
     * 通过审批.
     *
     * @param Request $request
     * @param WalletCash $cash
     * @return mixed
     */
    public function passed(Request $request, WalletCash $cash)
    {
        $remark = $request->input('remark');

        if (! $remark) {
            return response()
                ->json(['remark' => ['请输入备注信息']])
                ->setStatusCode(422);
        }

        $user = $request->user();
        $cash->status = 1;
        $cash->remark = $remark;

        // Charge
        $charge = new WalletCharge();
        $charge->amount = $cash->value;
        $charge->channel = $cash->type;
        $charge->action = 0;
        $charge->subject = '账户提现';
        $charge->body = $remark;
        $charge->account = $cash->account;
        $charge->status = 1;
        $charge->user_id = $user->id;

        DB::transaction(function () use ($cash, $charge) {
            $charge->save();
            $cash->save();

            $cash->user->sendNotifyMessage('user-cash:passed', '您申请的体现已通过，请注意查收', [
                'charge' => $charge,
                'cash' => $cash,
            ]);
        });

        return response()
            ->json(['message' => ['操作成功']])
            ->setStatusCode(201);
    }

    /**
     * 提现驳回.
     *
     * @param Request $request
     * @param WalletCash $cash
     * @return mixed
     */
    public function refuse(Request $request, WalletCash $cash)
    {
        $remark = $request->input('remark');

        if (! $remark) {
            return response()
                ->json(['remark' => ['请输入备注信息']])
                ->setStatusCode(422);
        }

        $user = $request->user();
        $cash->status = 2;
        $cash->remark = $remark;

        // Charge
        $charge = new WalletCharge();
        $charge->amount = $cash->value;
        $charge->channel = $cash->type;
        $charge->action = 0;
        $charge->subject = '账户提现';
        $charge->body = $remark;
        $charge->account = $cash->account;
        $charge->status = 2;
        $charge->user_id = $user->id;

        DB::transaction(function () use ($cash, $charge, $remark) {
            $cash->user->wallet()->increment('balance', $cash->value);
            $charge->save();
            $cash->save();

            $cash->user->sendNotifyMessage('user-cash:refuse', sprintf('您申请的体现已被拒绝，原因为：%s', $remark), [
                'charge' => $charge,
                'cash' => $cash,
            ]);
        });

        return response()
            ->json(['message' => ['操作成功']])
            ->setStatusCode(201);
    }
}
