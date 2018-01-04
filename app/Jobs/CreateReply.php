<?php

namespace Genv\Otc\Jobs;

use  Genv\Otc\Models\User;
use Genv\Otc\Modelss\Reply;
use Genv\Otc\Modelss\ReplyAble;
use App\Http\Requests\CreateReplyRequest;

class CreateReply
{
    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var \ Genv\Otc\Models\User
     */
    private $author;

    /**
     * @var \Genv\Otc\Modelss\ReplyAble
     */
    private $replyAble;

    public function __construct(string $body, string $ip, User $author, ReplyAble $replyAble)
    {
        $this->body = $body;
        $this->ip = $ip;
        $this->author = $author;
        $this->replyAble = $replyAble;
    }

    public static function fromRequest(CreateReplyRequest $request): self
    {
        return new static($request->body(), $request->ip(), $request->author(), $request->replyAble());
    }

    public function handle(): Reply
    {
        $reply = new Reply(['body' => $this->body, 'ip' => $this->ip]);
        $reply->authoredBy($this->author);
        $reply->to($this->replyAble);
        $reply->save();

        return $reply;
    }
}
