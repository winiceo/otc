<?php

namespace Genv\Otc\Queries;


use Genv\Otc\Models\Advert;
use Genv\Otc\Models\Order;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchTrade
{
    /**
     */
    public static function get(Request $request, int $perPage = 20): Paginator
    {


        return Ad::with("user")
            ->where(function ($query) use ($request) {


                $trade_type = $request->input('trade_type', 0);
                $query->where('trade_type', $trade_type);

            })
            ->paginate($perPage);


    }
}
