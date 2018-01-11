<?php



namespace Genv\Otc\Http\Controllers\APIs\V2;

use Illuminate\Http\Request;
use Genv\Otc\Packages\Wallet\Order;
use Illuminate\Database\Eloquent\Builder;
use Genv\Otc\Packages\Wallet\TypeManager;
use Genv\Otc\Http\Requests\API2\StoreUserWallerCashPost;

class WalletCashController extends Controller
{
    /**
     * 获取提现列表.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $after = $request->query('after');
        $limit = $request->query('limit', 15);

        $query = $user->walletCashes();
        $query->where(function (Builder $query) use ($after) {
            if ($after) {
                $query->where('id', '<', $after);
            }
        });
        $query->limit($limit);
        $query->orderBy('id', 'desc');

        return response()
            ->json($query->get(['id', 'value', 'type', 'account', 'status', 'remark', 'created_at']))
            ->setStatusCode(200);
    }

    /**
     * 提交提现申请.
     *
     * @param \Genv\Otc\Http\Requests\API2\StoreUserWallerCashPost $request
     * @return mixed
     */
    public function store(StoreUserWallerCashPost $request, TypeManager $manager)
    {
        $value = $request->input('value');
        $type = $request->input('type');
        $account = $request->input('account');
        $user = $request->user();

        if ($manager->driver(Order::TARGET_TYPE_WITHDRAW)->widthdraw($user, $value, $type, $account) === true) {
            return response()
                ->json(['message' => ['提交申请成功']])
                ->setStatusCode(201);
        }

        return response()->json(['message' => '操作失败'], 500);
    }
}
