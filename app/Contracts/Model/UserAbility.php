<?php



namespace Genv\Otc\Contracts\Model;

interface UserAbility
{
    /**
     * get users all roles.
     *
     * @param string $role
     * @return mixed
     */
    public function roles(string $role = '');

    /**
     * Get users all abilities.
     *
     * @param string $ability
     * @return mixed
     */
    public function all(string $ability = '');
}
