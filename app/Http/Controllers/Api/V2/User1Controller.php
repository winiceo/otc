<?php
/**
 * Created by PhpStorm.
 * User: genv
 * Date: 2017/12/18
 * Time: 下午8:32
 */

namespace Genv\Otc\Http\Controllers\Api\V2;


use  App\Model\User;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class User1Controller extends ApiController
{
    /**
     * 获取登录TOKEN
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request ,Response $response)
    {
        $user=Auth::User()->toArray();

       // return $this->setStatusCode(400)->message('23434');//->success($user);
        return $this->success($user);
    }
}