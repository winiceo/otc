<?php



namespace Genv\Otc\Packages\Wallet;

use Illuminate\Support\Manager;
use Genv\Otc\Packages\Wallet\TargetTypes\Target;

class TargetTypeManager extends Manager
{
    protected $order;

    /**
     * Set the manager order.
     *
     * @param \Genv\Otc\Packages\Wallet\Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the order target type driver.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->order->getOrderModel()->target_type;
    }

    /**
     * Create user target type driver.
     *
     * @return \Genv\Otc\Packages\TargetTypes\Target
     */
    protected function createUserDriver(): Target
    {
        $driver = $this->app->make(TargetTypes\UserTarget::class);
        $driver->setOrder($this->order);

        return $driver;
    }

    /**
     * Create widthdraw target type driver.
     *
     * @return \Genv\Otc\Packages\TargetTypes\Target
     * @author BS <414606094@qq.com>
     */
    protected function createWidthdrawDriver(): Target
    {
        $driver = $this->app->make(TargetTypes\WidthdrawTarget::class);
        $driver->setOrder($this->order);

        return $driver;
    }
}
