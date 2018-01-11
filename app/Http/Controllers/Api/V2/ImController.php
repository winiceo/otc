<?php

namespace Genv\Otc\Http\Controllers\Api\V2;


use App\Leven;

use Carbon\Carbon;
use Genv\Otc\Services\ChatService;
use Illuminate\Http\Request;


class ImController extends ApiController
{

    public function send(Request $request)
    {
        $params = $request->all();
        $message=ChatService::getMessage();
        $message=(object) array_merge((array) $message,(array) $params );

        $ret=ChatService::store($message);

        return $this->success($message) ;

    }

    public function history(Request $request, Chat $chat){

        $messages=$chat->where(function ($query) use ($request) {
            $order_id = $request->get('order_id', 0);
            $query->where('order_id', $order_id);
        })->orderBy('id', 'desc')
            ->paginate(20);

        return $this->success($messages);

    }

    public function upload(){



    }

}
