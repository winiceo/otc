<?php

namespace Genv\Otc\Queries;

use App\Ad;
use App\Model\Order;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchOrder
{
    /**
     */
    public static function get(Request $request, $user_id, int $perPage = 20): Paginator
    {

        return DB::table('ads')
            ->where(function ($query) use ($request,$user_id) {

                $query->where('user_id', $user_id);


                $coin = $request->input('coin', 1);
                $query->where('coin_type', $coin);


                $trade_type = $request->input('type', 0);
                $query->where('trade_type', $trade_type);


            })
            ->paginate($perPage);


    }
}
