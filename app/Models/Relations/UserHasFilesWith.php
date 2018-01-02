<?php



namespace Genv\Otc\Models\Relations;

use Genv\Otc\Models\FileWith;

trait UserHasFilesWith
{
    /**
     * user files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function files()
    {
        return $this->hasMany(FileWith::class, 'user_id', 'id');
    }
}
