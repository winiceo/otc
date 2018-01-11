<?php

namespace Genv\Otc\Jobs;


use Genv\Otc\Http\Requests\API2\AdvertRequest;
use Genv\Otc\Models\Advert;

use Genv\Otc\Models\User;
use Illuminate\Support\Facades\Auth;


class CreateAdvert
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var \Genv\Otc\Models\User
     */
    private $user;

    /**
     * @var array
     */
    private $params;

    public function __construct(User $user ,$params )
    {

        $this->user=$user;
        $this->params=$params;
    }

    public static function fromRequest(AdvertRequest $request): self
    {
        return new static(
            Auth::user(),
            $request->all()
        );
    }

    public function handle(): Advert
    {
        $thread = new Advert($this->params);
        $thread->userBy($this->user);

        $thread->save();

        return $thread;
    }
}
