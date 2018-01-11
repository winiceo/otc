<?php



namespace Genv\Otc\Models\Relations;

use Genv\Otc\Models\Like;

trait UserHasLike
{
    /**
     * Has likes for user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id', 'id');
    }

    /**
     * Has be likeds for user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function belikeds()
    {
        return $this->hasMany(Like::class, 'target_user', 'id');
    }
}
