<?php
/**
 * Created by PhpStorm.
 * User: genv
 * Date: 2017/11/30
 * Time: 下午8:21
 */

namespace Genv\Otc\Services;


use Genv\Otc\Helpers\CoinHelpers;
use Genv\Otc\Models\User;
use Genv\Otc\Models\UserBalance;
use Genv\Otc\Models\UserWallet;
use Genv\Otc\Models\WalletAddress;
use Genv\Otc\Models\Withdraw;
use Illuminate\Contracts\Pagination\Paginator;
use Slim\Http\Request;


class UserService
{
    use CoinHelpers;


    public static function checkWallet(User $user)
    {

        $coins = CoinHelpers::get();

        foreach ($coins as $coin) {
            $balance = UserBalance::where('coin_type', $coin['id'])
                ->where('user_id', $user->id)
                ->first();
            if (!$balance) {
                $data["user_id"] = $user->id;
                $data["coin_type"] = $coin['id'];
                $data["coin_name"] = $coin['name'];
                $data["block_balance"] = 0;
                $data["pending_balance"] = 0;
                $data["total_balance"] = 0;
                UserBalance::create($data);
            }
        }
    }


}