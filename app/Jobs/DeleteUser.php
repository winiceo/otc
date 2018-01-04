<?php

namespace Genv\Otc\Jobs;

use  Genv\Otc\Models\User;

class DeleteUser
{
    /**
     * @var \ Genv\Otc\Models\User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->user->delete();
    }
}
