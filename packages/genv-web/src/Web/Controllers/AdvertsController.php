<?php
/**
 * Created by PhpStorm.
 * User: genv
 * Date: 2017/12/29
 * Time: 10:45
 */

namespace Genv\Web\Web\Controllers;


use Genv\Otc\Helpers\CoinHelpers;
use App\Http\Requests\AdRequest;
use App\Http\Requests\AdvertRequest;
use Genv\Otc\Repository\AdvertRepository;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;

class AdvertsController extends Controller
{
    use CoinHelpers;

    protected $advert;

//    public function __construct(AdvertRepository $advert)
//    {
//
////
////        $this->middleware('auth')->except(['index', 'show']);
////        $this->advert=$advert;
////        $coins=CoinHelpers::get();
////        View::share('coins', $coins);
//
//
//    }


    public function create()
    {


        $price=Redis::command('hget', ['prices', 'btccny']);
        $price=\GuzzleHttp\json_decode($price);

        leven('price',$price->sell);



        return view('advert.create', compact('coins'));
    }


    public function store(AdRequest $request)
    {
        $data = array_merge($request->all(), [
            'user_id'      => \Auth::id(),

            'status'       => 0
        ]);

        dump($data);





        $this->ad->store($data);
        exit;

        return redirect()->to('discussion');
    }


    public function detail($id)
    {
        $advert = $this->advert->getById($id);
        leven('advert',$advert);

        return view('advert.detail', compact('advert'));
    }


    public function edit($id)
    {
        $advert = $this->advert->getById($id);

        $this->authorize('update', $advert);


        return view('advert.edit', compact('advert'));
    }




    public function update(AdvertRequest $request, $id)
    {
        $advert = $this->advert->getById($id);

        $this->authorize('update', $advert);

        $data = array_merge($request->all(), [
            'last_user_id' => \Auth::id()
        ]);

        $this->advert->update($id, $data);

        return redirect()->to("advert/{$id}");
    }
}