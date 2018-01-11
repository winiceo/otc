<?php

namespace Genv\Otc\Http\Controllers\Api\V2;

use Genv\Otc\Http\Controllers\Api\V2\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function login(Request $request)
    {


        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));

        exit;

        $credentials = $request->all();

        if (!$token = $this->guard()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        dump($token);
        try {
            /**
             * 验证用户身份，若校验通过，则声称token，反之回调
             * @var \Tymon\JWTAuth\JWTGuard
             */
            if (!$token = $this->guard()->attempt($credentials)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'invalid_credentials'
                ], 401);
            }
        } catch (JWTException $e) {


            /**
             * jwt 异常错误回调
             */
            return response()->json([
                'status' => 500,
                'message' => 'could_not_create_token'
            ], 500);
        }

        /**
         * 验证通过，将生成的token返回
         */
        return response()->json([
            "status" => 200,
            "message" => ["token" => $token]
        ]);
    }


    public function register(Request $request)
    {
        $input = $request->all();


        $rules = [
            //"username" => "required|max:30|min:3|unique:users,username",
            "password" => "required|max:16|min:6",
            //"email" => "nullable|unique:users,email|email",
            "mobile" => "nullable|unique:users,mobile|regex:/^1[34578][0-9]{9}$/",
            "verifycode" => "required"
        ];
        $messages = [];

        try {
            /**
             * 校验请求参数，若参数有误，则回调错误信息
             */


            $validator = Validator::make($input, $rules, $messages);


            if ($validator->fails()) {


                $errors = $validator->errors()->first();


                return response()->json([
                    'status' => 402,
                    'message' => $errors
                ], 402);
            }


            /**
             * 校验验证码，若验证码错误，回调错误信息
             */
            $callback = (new VerifyCode1Controller())->check_code($request);
            $content = $callback->content();
            if (json_decode($content, true)['status'] != 0) {
                return $callback;
            }

            /**
             * 参数校验正确，密码hash加密，并将用户信息存储数据库
             * 回调添加后的用户信息
             */

            $input['password'] = Hash::make($input['password']);
            unset($input['verifycode']);
            $input['username'] = $input['mobile'];
            $user = User::create($input);


            return response()->json([
                "code" => 0,
                "message" => $user
            ]);
        } catch (\Exception $e) {
            /**
             * 系统异常，回调异常信息
             */

            return response()->json([
                "code" => 500,
                "message" => $e
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 修改密码接口
     */
    public function resetPassword(Request $request)
    {
//        $new_password = $request->json('password');
//        /**
//         * 根据token获取用户信息，若失败，回调错误信息
//         */
//        if (!$user = JWTAuth::parseToken()->authenticate()) {
//            return response()->json([
//                "code" => 500,
//                "message" => "invalid token"
//            ], 500);
//        }
//        /**
//         * token验证成功，更新用户密码
//         * 回调更新后的用户信息
//         */
//        $user->password = Hash::make($new_password);
//        $user->save();
//        return response()->json([
//            "code" => 0,
//            "message" => $user
//        ]);

        $input = $request->all();
        $rules = [
            "password" => "required|max:16|min:6",
            "email" => "nullable|email",
            "telephone" => "nullable|regex:/^1[34578][0-9]{9}$/",
            "verifycode" => "required"
        ];
        $messages = [];

        try {
            /**
             * 校验请求参数，若参数有误，则回调错误信息
             */
            $validator = Validator::make($input, $rules, $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json([
                    'code' => 402,
                    'message' => $errors
                ], 402);
            }

            /**
             * 校验验证码，若验证码错误，回调错误信息
             */
            $callback = (new VerifyCode1Controller())->check_code($request);
            $content = $callback->content();
            if (json_decode($content, true)['code'] != 0) {
                return $callback;
            }

            /**
             * 参数校验正确，新密码密码hash加密，并更新用户信息
             * 回调更新后的用户信息
             */
            $input['password'] = Hash::make($input['password']);
            unset($input['verifycode']);

            if (array_key_exists('email', $input)) {
                User::where('email', $input['email'])
                    ->update($input);
            } else {
                User::where('telephone', $input['telephone'])
                    ->update($input);
            }

            return response()->json([
                "code" => 0,
                "message" => "success"
            ]);
        } catch (\Exception $e) {
            /**
             * 系统异常，回调异常信息
             */
            return response()->json([
                "code" => 500,
                "message" => $e
            ], 500);
        }
    }

}
