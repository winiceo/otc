<?php



namespace Genv\Otc\Models\Relations;

use Genv\Otc\Models\WalletCharge;

trait UserHasWalletCharge
{
    /**
     * User wallet charges.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function walletCharges()
    {
        return $this->hasMany(WalletCharge::class, 'user_id', 'id');
    }
}
