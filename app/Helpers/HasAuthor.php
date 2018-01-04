<?php

namespace Genv\Otc\Helpers;

use Genv\Otc\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function user(): User
    {
        return $this->user;
    }

    public function userBy(User $user)
    {
        $this->userRelation()->associate($user);
    }

    public function userRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isuserBy(User $user): bool
    {
        return $this->user()->matches($user);
    }
}
