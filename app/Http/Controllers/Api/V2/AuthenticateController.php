<?php
/**
 * Created by PhpStorm.
 * User: genv
 * Date: 2017/12/18
 * Time: 下午9:31
 */

namespace Genv\Otc\Http\Controllers\Api\V2;


namespace Genv\Otc\Http\Controllers\Api\V2;

use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;
use Socialite;

use App\Model\User;
use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;

class AuthenticateController extends ApiController
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('auth:api')->only([
            'logout'
        ]);
    }

    public function username()
    {
        return 'username';
    }


    // 登录
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'username' => 'required|exists:users',
            'password' => 'required|between:5,32',
        ]);

        if ($validator->fails()) {
            $request->request->add([
                'errors' => $validator->errors()->toArray(),
                'code' => 401,
            ]);
            return $this->sendFailedLoginResponse($request);
        }
        $credentials = $this->credentials($request);
        $token= $this->sendLoginResponse($request)->getContent();


        return $this->setStatusCode(200)->success(\GuzzleHttp\json_decode($token));
        //return $this->setStatusCode(401)->failed('登录失败');

    }


    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);
    }

    //注册
    public function register(Request $request)
    {
        $messages = [
            'required' => ':attribute 不能为空！',
            'min' => ':attribute 最少5位！',
            'unique' => ':attribute 已存在！',
        ];

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5'
        ], $messages);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()->first()], 422);

        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        $token=$this->sendLoginResponse($request);

        $data=[
            'user'=>Auth::user(),
            "token"=>$token
        ]  ;


        return $this->setStatusCode(200)->success(($data));
    }

    // 退出登录
    public function logout(Request $request)
    {

        if (Auth::guard('api')->check()) {

            Auth::guard('api')->user()->token()->revoke();

        }

        return $this->message('退出登录成功');

    }


    //调用认证接口获取授权码
    protected function authenticateClient(Request $request)
    {
        $credentials = $this->credentials($request);

        $password_client = Client::query()->where('password_client', 1)->latest()->first();

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $password_client->id,
            'client_secret' => $password_client->secret,
            'username' => $credentials[$this->username()],
            'password' => $credentials['password'],
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = \Route::dispatch($proxy);

        return $response;
    }

    protected function authenticated(Request $request)
    {
        return $this->authenticateClient($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($request);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $msg = $request['errors'];
        $code = $request['code'];
        return $this->setStatusCode($code)->failed($msg);
    }
}