<?php



namespace Genv\Otc\Models\Relations;

use Genv\Otc\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait UserHasWallet
{
    /**
     * Bootstrap the trait.
     *
     * @return void
     */
    public static function bootUserHasWallet()
    {
        // 用户创建后事件
        static::created(function ($user) {
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0]
            );

            if ($wallet === false) {
                return false;
            }
        });

        // 用户删除后事件
        static::deleted(function ($user) {
            $user->wallet()->delete();
        });
    }

    /**
     * User wallet.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }
}
