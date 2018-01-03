<?php

namespace Genv\Otc\Queries;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchWithdraw
{
    /**
     */
    public static function get(Request $request, $user_id, int $perPage = 20): Paginator
    {

        return DB::table('withdraw')
            ->where(function ($query) use ($request, $user_id) {

                $query->where('user_id', $user_id);

//
//                $coin = $request->input('coin_type', 1);
//                $query->where('coin_type', $coin);


            })
            ->paginate($perPage);


    }
}
