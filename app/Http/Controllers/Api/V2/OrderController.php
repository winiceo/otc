<?php
/**
 * Created by PhpStorm.
 * User: genv
 * Date: 2017/12/12
 * Time: 上午10:19
 */

namespace Genv\Otc\Http\Controllers\Api\V2;


use Genv\Otc\Helpers\CoinHelpers;
use Genv\Otc\Models\Order;
use Genv\Otc\Models\OrderComment;
use Genv\Otc\Models\UserBalance;
use Genv\Otc\Services\AdvertService;
use Genv\Otc\Services\ChatService;
use Genv\Otc\Services\OrderService;
use Carbon\Carbon;
use Genv\Otc\Events\OrderCreated;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class OrderController extends ApiController
{


    use CoinHelpers;

    public function getOrder( )
    {
        $params = \Illuminate\Support\Facades\Request::all();
        $user = Auth::user();
        $order = Order::with('aduser')->where('user_id', $user->id)
            ->where('id', $params["order_id"])
            ->first();
        return $order;

    }

    public function store(Request $request, Response $response)
    {


        if ($request->isMethod('post')) {

            Log::info('info', $request->all());
            $advert = AdvertService::get($request->get("advert_id",0));
            if (!$advert) {
                $this->failed('广告不存在');

            }
            Log::info('Leven:user', [Auth::user()]);


            $data = array_merge($request->all(), [
                'user_id' => Auth::id(),
                'order_code' => time(),
                'ad_id' => $advert->id,
                'ad_code' => "",
                'ad_user_id' => $advert->user_id,
                'buyer_estimate' => '',
                'seller_estimate' => '',
                'status' => 0,
                'coin_type' => $advert->coin_type,
            ]);

            if ($advert->user_id == Auth::id()) {
                $this->failed('不能自己给自己下单');
            }


            //获取可用余额
            $balance = UserBalance::where('user_id', $advert->user_id)
                ->where('coin_type', $advert->coin_type)
                ->first();
            if (!$balance) {
                $this->failed('用户账户信息丢失');
            }


            $can_balance = $balance->total_balance - $balance->block_balance - $balance->pending_balance;

            if ($data["qty"] > $can_balance) {
                $this->failed('此广告账户余额不足');
            }


            //if ($this->validator->isValid()) {

                $order = OrderService::store($data);

                $orderService = new OrderService($order);
                $orderService->sellerlockOrder();

            $orders=Redis::command('hset', ['monitoring_order', $order->id, Carbon::now()]);

            //放入监控
              //  $this->redis->hset('monitoring_order', $order->id, Carbon::now());
                Log::info('monitoring_order: ' . $order->id);

            broadcast(new OrderCreated(Auth::user(),$order));

            ChatService::setMessage($order,'CREATED');
                return $this->success( $order);

            //}

            //return $this->failed($response);
        }
        return $this->success([]);

    }


    public function getByUser(Request $request, Response $response)
    {

        $user = Auth::getUser();
        $adverts = OrderService::getByUser($request, $user);
        $coins = CoinHelpers::getIds();
        foreach ($adverts as $k => $v) {
            $adverts[$k]->coin_name = $coins[$v->coin_type]['name'];
        }

        return $this->success($adverts);

    }

    public function show(Request $request, Response $response, $id)
    {
        $advert = OrderService::get($id);

        return $this->success($advert);
    }


    /**
     * 付款完成
     * @param Request $request
     */
    public function pay(Request $request)
    {
        $order = $this->getOrder();

        if ($order) {
            //更新订单状态
            $order->status = Config::get('constants.ORDER_STATUS.PAY');
            $order->save();
            OrderService::log([
                "order_id" => $order->id,
                "message" => \GuzzleHttp\json_encode(["message" => 'created']),
                "status" => Config::get('constants.ORDER_STATUS.PAY')
            ]);
            $message=ChatService::setMessage($order,'PAY');

            broadcast(new OrderPay(Auth::user(),$order,$message));

        }
        return $this->success($order);


    }

    /**
     * 取消定单
     * @param Request $request
     */
    public function cancel(Request $request)
    {
        $order = $this->getOrder();

        if ($order) {

            //更新订单状态
            $order->status = Config::get('constants.ORDER_STATUS.CANCEL');
            $order->save();

            $orderService = new OrderService($order);
            OrderService::log([
                "order_id" => $order->id,
                "message" => \GuzzleHttp\json_encode(["message" => 'cancel']),
                "status" => Config::get('constants.ORDER_STATUS.CANCEL')
            ]);
            //Log::info('order_status_cancel: ' . Config::get('constants.ORDER_STATUS.CANCEL'));
            ChatService::setMessage($order,'CANCEL');
            $orderService->sellerUnlockOrder();
            broadcast(new OrderCancel(Auth::user(),$order));

        }
        return $this->success($order);;


    }


    /**
     * 放行定单
     * @param Request $request
     */
    public function release(Request $request)
    {
        $order = $this->getOrder();


        if ($order) {
            //更新订单状态
            $order->status = Config::get('constants.ORDER_STATUS.RELEASE');
            $order->save();

            //Log::info('order_status_release: ' . Config::get('constants.ORDER_STATUS.RELEASE'));

            $orderService = new OrderService($order);
            $orderService->orderRelease();

            OrderService::log([
                "order_id" => $order->id,
                "message" => \GuzzleHttp\json_encode(["message" => 'RELEASE']),
                "status" => Config::get('constants.ORDER_STATUS.RELEASE')
            ]);
            ChatService::setMessage($order,'CANCEL');

        }

        return $this->success($order);;


    }

    /**
     * 评价订单
     * @param Request $request
     */
    public function comment(Request $request)
    {
        $order = $this->getOrder();

        if ($order) {
            //更新订单状态
            $comment=[
                'order_id'=>$order->id,
                'message'=>$request->get('message')
            ];
            OrderComment::create($comment);

            $order->status = Config::get('constants.ORDER_STATUS.COMMENT');
            $order->save();

            OrderService::log([
                "order_id" => $order->id,
                "message" => \GuzzleHttp\json_encode(["message" => 'comment'])

            ]);
            ChatService::setMessage($order,'COMMENT');



        }
        return $this->success($order);;


    }

    /**
     * 审诉定单
     * @param Request $request
     */
    public function complaint(Request $request)
    {
        $order = $this->getOrder();
        if ($order) {
            //更新订单状态
            $order->status = Config::get('constants.ORDER_STATUS.COMPLAINT');
            $order->save();
            OrderService::log([
                "order_id" => $order->id,
                "message" => \GuzzleHttp\json_encode(["message" => 'complaint'])
            ]);

            ChatService::setMessage($order,'COMPLAINT');


        }
        return $this->success($order);;


    }


}