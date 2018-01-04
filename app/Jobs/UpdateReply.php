<?php

namespace Genv\Otc\Jobs;

use Genv\Otc\Modelss\Reply;

class UpdateReply
{
    /**
     * @var \Genv\Otc\Modelss\Reply
     */
    private $reply;

    /**
     * @var string
     */
    private $body;

    public function __construct(Reply $reply, string $body)
    {
        $this->reply = $reply;
        $this->body = $body;
    }

    public function handle()
    {
        $this->reply->update(['body' => $this->body]);
    }
}
