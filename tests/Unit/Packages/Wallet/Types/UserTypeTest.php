<?php



namespace Genv\Otc\Tests\Unit\Packages\Wallet\Types;

use Genv\Otc\Tests\TestCase;
use Genv\Otc\Packages\Wallet\Order;
use Genv\Otc\Packages\Wallet\Types\UserType;
use Genv\Otc\Models\WalletOrder as WalletOrderModel;
use Genv\Otc\Packages\Wallet\TargetTypes\UserTarget;

class UserTypeTest extends TestCase
{
    /**
     * Test Transfer.
     *
     * @return void
     */
    public function testTransfer()
    {
        $owner = 1;
        $target = 2;
        $amount = 100;

        // Create a order mock.
        $order = $this->getMockBuilder(Order::class)
                      ->setMethods(['autoComplete'])
                      ->getMock();

        // Set order::autoComplete return.
        $order->expects($this->once())
              ->method('autoComplete')
              ->willReturn(true);

        // Create a UserType mock.
        $userType = $this->getMockBuilder(UserType::class)
                         ->setMethods(['createOrder'])
                         ->getMock();

        // Set UserType::createOrder return.
        $userType->expects($this->once())
                 ->method('createOrder')
                 ->with($this->equalTo($owner), $this->equalTo($target), $this->equalTo($amount))
                 ->will($this->returnValue($order));

        $this->assertTrue($userType->transfer($owner, $target, $amount));
    }

    /**
     * Test createOrder method.
     *
     * @return void
     */
    public function testCreateOrder()
    {
        $model = new WalletOrderModel();
        $model->owner_id = 1;
        $model->target_type = Order::TARGET_TYPE_USER;
        $model->target_id = 2;
        $model->title = UserTarget::ORDER_TITLE;
        $model->type = Order::TYPE_EXPENSES;
        $model->amount = 100;
        $model->state = Order::STATE_WAIT;

        // Create a UserType::class mock.
        $userType = $this->getMockBuilder(UserType::class)
                         ->setMethods(['createOrderModel'])
                         ->getMock();

        // Set UserType::createOrderModel return.
        $userType->expects($this->once())
                 ->method('createOrderModel')
                 ->with($this->equalTo($model->owner_id), $this->equalTo($model->target_id), $this->equalTo($model->amount))
                 ->willReturn($model);

        $result = $userType->createOrder($model->owner_id, $model->target_id, $model->amount);
        $this->assertInstanceOf(Order::class, $result);
    }

    /**
     * Test create order model.
     *
     * @return void
     */
    public function testCreateOrderModel()
    {
        $owner = 1;
        $target = 2;
        $amount = 100;
        $userType = new UserType();
        $model = $userType->createOrderModel($owner, $target, $amount);

        $this->assertInstanceOf(WalletOrderModel::class, $model);
        $this->assertSame($owner, $model->owner_id);
        $this->assertSame($target, $model->target_id);
        $this->assertSame($amount, $model->amount);
        $this->assertSame(Order::TARGET_TYPE_USER, $model->target_type);
        $this->assertSame(Order::TYPE_EXPENSES, $model->type);
        $this->assertSame(Order::STATE_WAIT, $model->state);
        $this->assertSame(UserTarget::ORDER_TITLE, $model->title);
    }
}
