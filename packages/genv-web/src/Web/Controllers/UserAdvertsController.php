<?php
/**
 * Created by PhpStorm.
 * User: genv
 * Date: 2017/12/29
 * Time: 14:36
 */

namespace Genv\Web\Web\Controllers;


use Genv\Otc\Helpers\CoinHelpers;
use App\Http\Requests\AdRequest;

use App\Queries\SearchAdvert;
use App\Queries\SearchOrder;
use Genv\Otc\Repository\AdvertRepository;
use Genv\Otc\Repository\DiscussionRepository;
use Genv\Otc\Repository\OrderRepository;
use Genv\Otc\Repository\TagRepository;
use Genv\Otc\Repository\UserRepository;
use Auth;
use Illuminate\Http\Request;

class UserAdvertsController extends Controller
{

    protected $user;

    protected $order;

    public function __construct(UserRepository $user,OrderRepository $order)
    {
        $this->user = $user;
        $this->order=$order;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $this->user->getById(Auth::id());



        $orders= SearchAdvert::get($request,$user->id);
        $coins=CoinHelpers::getIds();


        foreach ($orders as $k=>$v){

            $orders[$k]->coin_name=$coins[$v->coin_type]['name'];
        }



        return view('userad.index', compact('user','orders'));
    }


}
