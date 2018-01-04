<?php

namespace Genv\Web\Web\Controllers;

use function Genv\Otc\Helpers\bee_config;
use Genv\Otc\Helpers\CoinHelpers;
use App\Http\Requests\AdRequest;

use Genv\Otc\Repository\AdvertRepository;
use Genv\Otc\Repository\DiscussionRepository;
use Genv\Otc\Repository\OrderRepository;
use Genv\Otc\Repository\TagRepository;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Request;
use Auth;
class ChatController extends Controller
{

    use CoinHelpers;

    protected $order;

    public function __construct(OrderRepository $order, TagRepository $tag)
    {
        $this->middleware('auth');


        $this->order=$order;

    }

    public function upload(Request $request){
        $orderid=$request->input('orderid');
        return view('chat.upload',compact('orderid'));
    }


    public function store(Request $request)
    {
        $data = array_merge($request->all(), [


            'status'       => 0
        ]);

        $order = $this->order->getById($data['orderid']);

        $user= Auth::user();
        $from_user_id=0;
        $to_user_id=0;
        if ($user->id == $order->ad_user_id) {

            $from_user_id=$order->ad_user_id;
            $to_user_id=$order->user_id;

        }
        if($user->id==$order->user_id){
            $from_user_id=$order->user_id;
            $to_user_id=$order->ad_user_id;

        }


        dump($to_user_id);

       // $order_im_token = app('rcloud')->user()->getToken(env('RONG_CLOUD_ID_PRE') . $order->user->id, $order->user->name, $order->user->avatar);

        if($request->hasFile('upchatpic') && $request->file('upchatpic')->isValid()) {
            //获取上传的文件
            $file = $request->file('upchatpic');
            //$name = $file->getClientOriginalName();
            if ($store_result = $file->store('chat', 'public')) {

                return response()->json(['success' => 'true','file'=>$store_result], 200);

//                $content=[
//                    "content"=>"ergaqreg",
//                    "imageUri"=>"/storage/".$store_result,
//                    "extra"=>["order_id"=>$order->id]
//                ];
//                $content=\GuzzleHttp\json_encode($content);
//
//                $ret=app('rcloud')->Message()->publishPrivate(env('RONG_CLOUD_ID_PRE') .$from_user_id,env('RONG_CLOUD_ID_PRE') .$to_user_id,'RC:ImgMsg', $content,'','','',0,1,1,1);
//
//
//                return response()->json(['success' => 'true'], 200);
            }
        }else{

            //todo
            return redirect()->back();
        }




       // $this->ad->store($data);
        exit;

        return redirect()->to('discussion');
    }



}
