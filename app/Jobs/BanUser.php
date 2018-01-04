<?php

namespace Genv\Otc\Jobs;

use Genv\Otc\Models\User;
use Carbon\Carbon;

class BanUser
{
    /**
     * @var \ Genv\Otc\Models\User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): User
    {
        $this->user->banned_at = Carbon::now();
        $this->user->save();

        return $this->user;
    }
}
