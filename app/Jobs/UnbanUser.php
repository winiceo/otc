<?php

namespace Genv\Otc\Jobs;

use  Genv\Otc\Models\User;

class UnbanUser
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
        $this->user->banned_at = null;
        $this->user->save();

        return $this->user;
    }
}
