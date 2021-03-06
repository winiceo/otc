<?php

namespace Genv\Otc\Jobs;

use  Genv\Otc\Models\User;
use Illuminate\Contracts\Hashing\Hasher;

class UpdatePassword
{
    /**
     * @var \ Genv\Otc\Models\User
     */
    private $user;

    /**
     * @var string
     */
    private $newPassword;

    public function __construct(User $user, string $newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }

    public function handle(Hasher $hasher)
    {
        $this->user->update(['password' => $hasher->make($this->newPassword)]);
    }
}
