<?php



namespace Genv\Otc\Models\Relations;

use Genv\Otc\Models\Comment;

trait UserHasComment
{
    /**
     * Has comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
}
