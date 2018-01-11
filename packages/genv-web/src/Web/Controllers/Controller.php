<?php

namespace Genv\Web\Web\Controllers;

use Genv\Otc\Helpers\CoinHelpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function __construct(Request $request)
    {

        $coins=CoinHelpers::get();
        View::share('coins', $coins);

        $user = auth()->user();
        dump($user);



        $public = [
            'csrf_token' => csrf_token(),
            'base_url'   => url('admin'),
            'api'        => url('api/v2'),
            'logged'     => (bool) $user,


        ];
        if($user){
            $public["user"]=$user;
            $public['token'] = JWTAuth::fromUser($user);
        }else{
            $public["user"]=false;
            $public['token'] = false;

        }

        View::share('public',$public);



    }



}
