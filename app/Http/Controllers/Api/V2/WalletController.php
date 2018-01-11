<?php

namespace Genv\Otc\Http\Controllers\Api\V2;

use Genv\Otc\ServiceS\UserWalletService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;


class WalletController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function address(Request $request, Response $response)
    {
//        $user=$this->auth->getUser();
//        if(!$user){
//            $this->error('获取用户失败');
//            return $this->fail($response,[]);
//        }


        $address = UserWalletService::address($this->auth->getUser());
        return $this->json($response, $address);
    }


    public function storeAddress(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $this->validator->request($request, [
                'coin_type' => v::numeric()->length(1, 1),
                'address' => v::stringType()->notEmpty()

            ]);
            $data = $request->getParams();

            $data["user_id"] = $this->auth->getUser()->getUserId();

            if (UserWalletService::isExistAddress($data) != null) {
                $this->error('已存在此地址');
            }
            if ($this->validator->isValid()) {


                $address = UserWalletService::storeAddress($data);
                return $this->json($response, $address);
            }
            return $this->fail($response);
        }
        return $this->fail($response);

    }

    public function deposit(Request $request, Response $response, $args)
    {

        $coin_type = $args['id'];
        $user_id = $this->auth->getUser()->getUserId();


        $address = UserWalletService::getWalletAddress($user_id, $coin_type);
        return $this->json($response, $address);

    }


    public function withdraw(Request $request, Response $response)
    {


        if ($request->isPost()) {
            $this->validator->request($request, [
                'coin_type' => v::numeric()->length(1, 1),
                'address' => v::stringType()->notEmpty(),
                'amount' => v::numeric()->length(1, 20)->notEmpty()

            ]);
            $data = $request->getParams();

            $data["user_id"] = $this->auth->getUser()->getUserId();

            $data['order_code'] = time();

            if ($this->validator->isValid()) {


                $address = UserWalletService::storeWithdraw($data);
                return $this->json($response, $address);
            }
            return $this->error($response);
        }
        return $this->error($response);

    }


    public function history(\Illuminate\Http\Request $request,  ResponseFactoryContract $response)
    {

        $withdraws = UserWalletService::getHistory($request,  Auth::user() );
        //return $this->json($response, $withdraws);
        return $response->json(['data' => $withdraws], 200);


    }


}
