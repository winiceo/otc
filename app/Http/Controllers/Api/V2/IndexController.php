<?php
/**
 * Created by PhpStorm.
 * User: genv
 * Date: 2017/12/18
 * Time: 下午6:31
 */

namespace Genv\Otc\Http\Controllers\Api\V2;

class IndexController extends ApiController
{
    public function index(){

        return $this->message('请求成功');
    }
}

