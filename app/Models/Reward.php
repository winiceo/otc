<?php



namespace Genv\Otc\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Has rewardable.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function rewardable()
    {
        return $this->morphTo();
    }

    /**
     * Has user for the rewardable.
     *
     * @author bs<414606094@qq.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|null
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Has target for the rewardable.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function target()
    {
        return $this->hasOne(User::class, 'id', 'target_user');
    }
}
