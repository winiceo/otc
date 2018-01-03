<?php
/**
 * Created by PhpStorm.
 * User: genv
 * Date: 2017/12/10
 * Time: 下午11:08
 */

namespace App\Service;


use App\Http\Controllers\Api\V2\ApiController;
use App\Leven;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Request;
use Yunpian\Sdk\YunpianClient;

class SmsService extends ApiController
{



    public static function send($mobile)
    {





        $code=Leven::generate_code(4);
        // Redis::command('hset', ['safe_check', $mobile,$code]);
        Cache::put($mobile, $code, 10);


        if($mobile){
            //初始化client,apikey作为所有请求的默认值
            $clnt = YunpianClient::create(env("YUNPIAN_API"));
            $param = [YunpianClient::MOBILE => $mobile,YunpianClient::TEXT => '【币赢科技】 您的验证码是 '.$code];
            $r = $clnt->sms()->single_send($param);
            return true;
        }
        return false;
    }


}