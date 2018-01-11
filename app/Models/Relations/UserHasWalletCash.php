<?php



namespace Genv\Otc\Models\Relations;

use Genv\Otc\Models\WalletCash;

trait UserHasWalletCash
{
    /**
     * Wallet cshs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function walletCashes()
    {
        return $this->hasMany(WalletCash::class, 'user_id', 'id');
    }
}
