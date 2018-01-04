<?php

namespace Genv\Otc\Jobs;

use Genv\Otc\Modelss\Reply;

class DeleteReply
{
    /**
     * @var \Genv\Otc\Modelss\Reply
     */
    private $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    public function handle()
    {
        $this->reply->delete();
    }
}
