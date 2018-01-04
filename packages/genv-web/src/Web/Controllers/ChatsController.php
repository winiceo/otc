<?php

namespace Genv\Web\Web\Controllers;

use Illuminate\Http\Request;
use Genv\Otc\Models\Message;
 use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $order_id=$request->get('id');

        return view('chat',['order_id' => $order_id]);
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
//    public function sendMessage(Request $request)
//    {
//        $user = Auth::user();
//
//        $message = $user->messages()->create([
//            'message' => $request->input('message')
//        ]);
//
//        return ['status' => 'Message Sent!'];
//    }


    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

//        $message=$user->messages()->first();



        broadcast(new MessageSent($user, $message));;//->toOthers();


       // broadcast(new MessageSent($user, $message)) ;

        return ['status' => 'Message Sentasdfasfasd!'];
    }
}
