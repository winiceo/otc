<?php



namespace Genv\Otc\Services;

use Illuminate\Support\Collection;
use Genv\Otc\Models\User as UserModel;
use Genv\Otc\Contracts\Model\UserAbility as UserAbilityContract;

class UserAbility implements UserAbilityContract
{
    protected $user;

    /**
     * Get all roles or get first role.
     *
     * @param string $role
     * @return mixed
     */
    public function roles(string $role = '')
    {
        $roles = $this->user()
            ->roles()
            ->get()
            ->keyBy('name');

        if (! $role) {
            return $roles;
        }

        return $roles->get($role, false);
    }

    /**
     * Get all abilities or get first ability.
     *
     * @param string $ability
     * @return mixed
     */
    public function all(string $ability = '')
    {
        $roles = $this->roles();
        $roles->load('abilities');
        $abilities = $roles->reduce(function ($collect, $role) {
            return $collect->merge(
                $role->abilities->keyBy('name')
            );
        }, new Collection());

        if (! $ability) {
            return $abilities;
        }

        return $abilities->get($ability, false);
    }

    /**
     * Get user instance.
     *
     * @return \Genv\Otc\Models\User
     */
    public function user(): UserModel
    {
        return $this->user;
    }

    /**
     * Set user model.
     *
     * @param \Genv\Otc\Models\User $user
     */
    public function setUser(UserModel $user)
    {
        $this->user = $user;

        return $this;
    }
}
