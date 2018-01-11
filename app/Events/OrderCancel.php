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

class OrderCancel implements ShouldBroadcast
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



    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,Order $order)
    {
        $this->user=$user;
        $this->order=$order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('order.'.$this->order->id);

        //return new PrivateChannel('channel-name');
    }

    public function broadcastAs()
    {
        return 'order.cancel';
    }
}
