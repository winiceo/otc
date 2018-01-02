<?php



namespace Genv\Otc\Packages\Wallet\TargetTypes;

use Genv\Otc\Packages\Wallet\Order;

abstract class Target
{
    /**
     * The order service.
     *
     * @var \Genv\Otc\Packages\Wallet\Order
     */
    protected $order;

    /**
     * Set the order service.
     *
     * @param \Genv\Otc\Packages\Wallet\Order $order
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
    }
}
