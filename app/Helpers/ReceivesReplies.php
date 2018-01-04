<?php

namespace Genv\Otc\Helpers;

use Genv\Otc\Modelss\Reply;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ReceivesReplies
{
    /**
     * @return \Genv\Otc\Modelss\Reply[]
     */
    public function replies()
    {
        return $this->repliesRelation;
    }

    /**
     * @return \Genv\Otc\Modelss\Reply[]
     */
    public function latestReplies(int $amount = 5)
    {
        return $this->repliesRelation()->latest()->limit($amount)->get();
    }

    public function deleteReplies()
    {
        $this->repliesRelation()->delete();
    }

    public function repliesRelation(): MorphMany
    {
        return $this->morphMany(Reply::class, 'replyable');
    }
}
