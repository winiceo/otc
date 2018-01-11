<?php



namespace Genv\Otc\Packages\Wallet\Types;

use Genv\Otc\Packages\Wallet\Order;
use Genv\Otc\Models\User as UserModel;
use Genv\Otc\Models\WalletOrder as WalletOrderModel;
use Genv\Otc\Packages\Wallet\TargetTypes\UserTarget;

class UserType extends Type
{
    /**
     * User to user transfer.
     *
     * @param int|\Genv\Otc\Models\User $owner
     * @param int|\Genv\Otc\Models\User $target
     * @param int $amount
     * @return bool
     */
    public function transfer($owner, $target, int $amount): bool
    {
        $owner = $this->resolveGetUserId($owner);
        $target = $this->resolveGetUserId($target);
        $order = $this->createOrder($owner, $target, $amount);

        return $order->autoComplete();
    }

    /**
     * Resolve get user id.
     *
     * @param int|\Genv\Otc\Models\User $user
     * @return int
     */
    protected function resolveGetUserId($user): int
    {
        if ($user instanceof UserModel) {
            return $user->id;
        }

        return (int) $user;
    }

    /**
     * Create a order.
     *
     * @param int $owner
     * @param int $target
     * @param int $amount
     * @return \Genv\Otc\Packages\Wallet\Order
     */
    public function createOrder(int $owner, int $target, int $amount): Order
    {
        return new Order($this->createOrderModel($owner, $target, $amount));
    }

    /**
     * Create order model.
     *
     * @param int $owner
     * @param int $target
     * @param int $amount
     * @return \Ziyi\Plus\Models\WalletOrder
     */
    public function createOrderModel(int $owner, int $target, int $amount): WalletOrderModel
    {
        $order = new WalletOrderModel();
        $order->owner_id = $owner;
        $order->target_type = Order::TARGET_TYPE_USER;
        $order->target_id = $target;
        $order->title = UserTarget::ORDER_TITLE;
        $order->type = Order::TYPE_EXPENSES;
        $order->amount = $amount;
        $order->state = Order::STATE_WAIT;

        return $order;
    }
}
