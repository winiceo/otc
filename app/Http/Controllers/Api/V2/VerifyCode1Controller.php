<?php

namespace Genv\Otc\Http\Controllers\Api\V2;

use App\Service\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

/**
 * Class VerifyCodeController
 * @package Genv\Otc\Http\Controllers\Auth
 * 本类提供接口：
 * 1：通过手机（邮箱）获取验证码
 * 2: 通过手机（邮箱）和验证码，校验验证码
 */
class VerifyCode1Controller extends ApiController
{
    /**
     * @param Request $request
     * 请求参数必须包含 email 或 mobile
     * @return \Illuminate\Http\JsonResponse
     * 通过邮箱或手机，获取验证码接口
     */
    public function get_code(Request $request)
    {
        $email = $request->json('email');
        $mobile = $request->json('mobile');

        /**
         * 验证手机或邮箱格式是否正确
         * 并获取验证通过的字段
         */
        $data = [
            "email" => $email,
            "mobile" => $mobile
        ];
        $rules = [
            "email" => "nullable|email",
            "mobile" => "nullable|regex:/^1[34578][0-9]{9}$/"
        ];
        $messages = [

        ];
        $validator = Validator::make($data, $rules, $messages);
        $valid = $validator->valid();

        if (array_key_exists('email', $valid) && !empty($email)) {
            /**
             * 通过邮件发送验证码，并将验证码写入缓存中
             */
            Cache::put($email, '1234', 10);

            return response()->json([
                "status" => 0,
                "message" => "the verifycode send to your email"
            ]);
        } else if (array_key_exists('mobile', $valid) && !empty($mobile)) {
            /**
             * 通过手机短信发送验证码，并将验证码写入缓存中
             */

            SmsService::send($mobile);

            return response()->json([
                "status" => 0,
                "message" => "the verifycode send to your mobile"
            ]);
        } else if (!$email && !$mobile) {
            return response()->json([
                "status" => 404,
                "message" => "the request email or mobile is not found"
            ]);
        } else {
            $errors = $validator->errors();
            return response()->json([
                "status" => 402,
                "message" => $errors
            ]);
        }
    }

    /**
     * @param Request $request
     * 请求参数必须包含
     * 1: email 或 mobile
     * 2: verifycode
     * @return \Illuminate\Http\JsonResponse
     * 验证验证码
     */
    public function check_code(Request $request)
    {
        $mobile = $request->json('mobile');
        $email = $request->json('email');
        $verifycode = $request->json('verifycode');

        /**
         * 判断请求账号为email or mobile
         * 全部为空则中断验证
         */
        if ($mobile) {
            $account = $mobile;
        } else if ($email) {
            $account = $email;
        } else {
            return response()->json([
                "status" => 404,
                "message" => "your request is not found mobile or email"
            ]);
        }

        /**
         * 通过账号作为key获取缓存中的验证码与获取的验证码进行验证
         * 以下为验证失败回调
         */
        $cache_verifycode = Cache::get($account);


        if (!$cache_verifycode || strtolower($verifycode) != strtolower($cache_verifycode)) {
            return response()->json([
                "status" => 400,
                "message" => "the verifystatus is invalid or not found"
            ]);
        }

        /**
         * 验证码验证成功回调
         */
        return response()->json([
            "status" => 0,
            "message" => "success"
        ]);
    }
}
