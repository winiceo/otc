<?php

namespace Genv\Otc\Jobs;

use  Genv\Otc\Models\User;

class ConfirmUser
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
        $this->user->update(['confirmed' => true, 'confirmation_code' => null]);

        return $this->user;
    }
}
