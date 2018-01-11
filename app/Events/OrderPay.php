<?php

namespace App\Events;

use App\Model\Order;
use App\Model\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class OrderPay implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * User that sent the message
     *
     * @var User
     */
    public $user;

    /**
     * @var \App\Model\Order
     */
    public $order;


    public $message;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,Order $order,$message)
    {
        $this->user=$user;
        $this->order=$order;
        $this->message=$message;

        Log::info('message',[$message]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('order.'.$this->order->id);
        return new Channel('order');

        //return new PrivateChannel('channel-name');
    }

//    public function broadcastAs()
//    {
//        return 'order.pay';
//    }
}
