<?php

namespace Genv\Web\Web\Controllers;

use Genv\Otc\Models\UserBalance;
use  Genv\Otc\Models\User;
use Auth;
use Hash;
use Image;
use Laravolt\Avatar\Avatar;
use Validator;
use Illuminate\Http\Request;
use App\Notifications\FollowedUser;
use Genv\Otc\Repository\UserRepository;

class UserInfoController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    public function update(Request $request)
    {

        $user = Auth::user();

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            //获取上传的文件
            $file = $request->file('file');
            //$name = $file->getClientOriginalName();
            if ($store_result = $file->store('images', 'public')) {
                $user->avatar = '/storage/' . $store_result;
                $user->save();
                return redirect()->back();

                // return response()->json(['success' => 'true'], 200);
            }
        } else {

            //todo
            return redirect()->back();
        }

    }


    public function avatar(Request $request, $id)
    {



        $user_id = str_replace('bee', '', $id);
        $user = User::findOrFail($user_id);
        return redirect($user->avatar);

        $path=storage_path('app/public/users/'.$user_id.'.png');
        $a=\Avatar::create($user->name)->save($path, $quality = 90);
        return redirect('/storage/users/'.$user_id.'.png');


    }


}
