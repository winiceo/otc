<?php



namespace Genv\Otc\Http\Controllers\APIs\V2;

use Illuminate\Http\Request;
use Genv\Otc\Models\PaidNode as PaidNodeModel;
use Genv\Otc\Models\WalletCharge as WalletChargeModel;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseContract;

class PurchaseController extends Controller
{
    /**
     * 获取付费节点和当前用户的付费状态.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Genv\Otc\Models\PaidNode $node
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function show(Request $request, ResponseContract $response, PaidNodeModel $node)
    {
        $node->paid = $node->paid(
            $request->user()->id
        );

        return $response->json($node)->setStatusCode(200);
    }

    /**
     * 支付节点费用.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Genv\Otc\Models\PaidNode $node
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */

    /**
     * 支付节点费用.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Illuminate\Contracts\Cache\Repository $cache
     * @param \Genv\Otc\Models\WalletCharge $charge
     * @param \Genv\Otc\Models\PaidNode $node
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function pay(Request $request, ResponseContract $response, CacheContract $cache, WalletChargeModel $charge, PaidNodeModel $node)
    {
        $user = $request->user();
        $user->load('wallet');
        $nodeUser = $node->user;

        if ($node->paid($user->id)) {
            return $response->json([
                'message' => ['已经支付费用不能重复支付'],
            ])->setStatusCode(422);
        } elseif (! $user->wallet || $user->wallet->balance < $node->amount) {
            return $response->json([
                'message' => ['余额不足'],
            ])->setStatusCode(403);
        }

        $user->getConnection()->transaction(function () use ($user, $node, $nodeUser, $charge) {
            // 扣除用户余额
            $user->wallet()->decrement('balance', $node->amount);

            // 插入用户扣除费用订单记录
            $userCharge = clone $charge;
            $userCharge->channel = $nodeUser ? 'user' : 'system';
            $userCharge->account = $node->user_id;
            $userCharge->action = 0;
            $userCharge->amount = $node->amount;
            $userCharge->subject = $node->subject;
            $userCharge->body = $node->body;
            $userCharge->status = 1;
            $user->walletCharges()->save($userCharge);

            // 插入购买用户
            $node->users()->sync($user->id, false);

            // 存在发起人钱包，则插入，否则上述余额扣除后不增加到任何账户。
            if ($nodeUser) {
                if ($nodeUser->wallet) {
                    // 为发起人钱包增加
                    $nodeUser->wallet->increment('balance', $node->amount);

                    // 添加收款订单
                    $charge->channel = 'user';
                    $charge->account = $user->id;
                    $charge->action = 1;
                    $charge->amount = $node->amount;
                    $charge->subject = '被'.$node->subject;
                    $charge->body = $charge->subject;
                    $charge->status = 1;
                    $charge->user_id = $nodeUser->id;
                    $charge->save();

                    // 被购买通知
                    $nodeUser->sendNotifyMessage('paid:'.$node->channel, '被'.$user->name.$node->body, [
                        'charge' => $charge,
                        'user' => $user,
                    ]);
                }
            }
        });

        $cacheKey = sprintf('paid:%s,%s', $node->id, $user->id);
        $cache->forget($cacheKey);

        return $response->json([
            'message' => ['付费成功'],
        ])->setStatusCode(201);
    }
}
