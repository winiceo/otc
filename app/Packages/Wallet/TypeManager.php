<?php



namespace Genv\Otc\Packages\Wallet;

use Illuminate\Support\Manager;
use Genv\Otc\Packages\Wallet\Types\Type;

class TypeManager extends Manager
{
    /**
     * Get default type driver.
     *
     * @return string User type
     */
    public function getDefaultDriver()
    {
        return Order::TARGET_TYPE_USER;
    }

    /**
     * Create user driver.
     *
     * @return \Genv\Otc\Packages\Wallet\Types\Type
     */
    protected function createUserDriver(): Type
    {
        return $this->app->make(Types\UserType::class);
    }

    /**
     * Create widthdraw driver.
     *
     * @return \Genv\Otc\Packages\Wallet\Types\Type
     * @author BS <414606094@qq.com>
     */
    protected function createWidthdrawDriver(): Type
    {
        return $this->app->make(Types\WidthdrawType::class);
    }
}
