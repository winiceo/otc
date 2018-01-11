<?php
/**
 * Created by PhpStorm.
 * User: genv
 * Date: 2017/12/18
 * Time: 下午8:32
 */

namespace Genv\Otc\Http\Controllers\Api\V2;


use App\Model\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Faker\Provider\DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use League\Flysystem\Exception;
use Parse\ParseUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Mail\TestEmail;



use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseException;
class TestController extends ApiController
{
    /**
     * 获取登录TOKEN
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {

        $credentials = [
            'username'    => 'leven',
            'password' => '123456',
        ];

        $token=Sentinel::register($credentials);

        dump($token);
    }
}