<?php


namespace Genv\Otc\Http\Controllers\Api\V2;

use Genv\Otc\Http\Controllers\Api\V2\ApiController;
use Genv\Otc\Http\Requests\API2\StoreUserPost;
use Genv\Otc\Http\Requests\API2\UserPost;
use Genv\Otc\Http\Requests\RegisterRequest;
use Genv\Otc\Models\CommonConfig;
use Genv\Otc\Models\User;
use Genv\Otc\Models\VerificationCode;
use Illuminate\Http\Request;
use function Genv\Otc\username;
use Genv\Otc\Auth\JWTAuthToken;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception\RuntimeException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends ApiController
{
    public function __construct()
    {
        $this->middleware(Authenticate::class, ['only' => 'send']);
    }

    public function login(Request $request, ResponseFactoryContract $response, JWTAuthToken $jwtAuthToken, User $model)
    {
        $login = $request->input('username', '');
        $password = $request->input('password', '');

        $user = $model->where(username($login), $login)->with('wallet')->withCount('administrator')->first();

        if (!$user) {
            return $response->json(['login' => ['用户不存在']], 404);
        } elseif (!$user->verifyPassword($password)) {
            return $response->json(['password' => ['密码错误']], 422);
        } elseif ($user->roles->whereStrict('id', 3)->isNotEmpty()) { // 禁止登录用户
            return $response->json(['message' => ['你已被禁止登陆']], 422);
        } elseif (($token = $jwtAuthToken->create($user))) {
            return $response->json([
                'token' => $token,
                'user' => array_merge($user->toArray(), [
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'wallet' => $user->wallet,
                ]),
                'ttl' => config('jwt.ttl'),
                'refresh_ttl' => config('jwt.refresh_ttl'),
            ])->setStatusCode(201);
        }

        return $response->json(['message' => ['Failed to create token.']])->setStatusCode(500);
    }

    /**
     * Refresh a user token.
     *
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Tymon\JWTAuth\JWTAuth $auth
     * @param string $token
     * @return mixed
     */
    public function refresh(ResponseFactoryContract $response, JWTAuthToken $jwtAuthToken, string $token)
    {
        if (!($token = $jwtAuthToken->refresh($token))) {
            return $response->json(['message' => ['Failed to refresh token.']], 500);
        }

        return $response->json([
            'token' => $token,
            'ttl' => config('jwt.ttl'),
            'refresh_ttl' => config('jwt.refresh_ttl'),
        ])->setStatusCode(201);
    }


    /**
     * 创建用户.
     *
     * @return mixed
     */
    public function register(UserPost $request, ResponseFactoryContract $response, JWTAuth $auth)
    {



        $phone = $request->input('phone');
        $email = $request->input('email');
        $name = $request->input('name');
        $password = $request->input('password');
        $channel = $request->input('verifiable_type');
        $code = $request->input('verifiable_code');

        if (in_array($name, (array)explode(',', config('site.reserved_nickname')))) {
            return $response->json(['message' => '用户名为系统保留，无法使用！'], 422);
        }

        $role = CommonConfig::byNamespace('user')
            ->byName('default_role')
            ->firstOr(function () {
                throw new RuntimeException('Failed to get the defined user group.');
            });

        $verify = VerificationCode::where('account', $channel == 'mail' ? $email : $phone)
            ->where('channel', $channel)
            ->where('code', $code)
            ->orderby('id', 'desc')
            ->first();

        if (!$verify) {
          //  return $response->json(['message' => ['验证码错误或者已失效']], 422);
        }

        $user = new User();
        $user->phone = $phone;
        $user->email = $email;
        $user->name = $name;
        $user->createPassword($password);

       // $verify->delete();
        if (!$user->save()) {
            return $response->json(['message' => ['注册失败']], 500);
        }

        $user->roles()->sync($role->value);

        return $response->json([
            'token' => $auth->fromUser($user),
            'ttl' => config('jwt.ttl'),
            'refresh_ttl' => config('jwt.refresh_ttl'),
        ])->setStatusCode(201);
    }
}
