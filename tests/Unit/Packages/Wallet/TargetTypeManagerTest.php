<?php



namespace Genv\Otc\Tests\Unit\Packages\Wallet;

use Genv\Otc\Tests\TestCase;
use Genv\Otc\Packages\Wallet\Order;
use Genv\Otc\Packages\Wallet\TargetTypeManager;
use Genv\Otc\Models\WalletOrder as WalletOrderModel;
use Genv\Otc\Packages\Wallet\TargetTypes\UserTarget;

class TargetTypeManagerTest extends TestCase
{
    /**
     * Test TargetTypeManager.
     *
     * @return void
     */
    public function testBaseClass()
    {
        // Create a WalletOrderModel::class
        $model = new WalletOrderModel();

        // Create a Order::class mock.
        $order = $this->getMockBuilder(Order::class)
                      ->setMethods(['getOrderModel'])
                      ->getMock();
        $order->expects($this->exactly(1))
              ->method('getOrderModel')
              ->willReturn($model);

        // Create a TargetTypeManager::class
        $targetTypeManager = new TargetTypeManager($this->app);
        $targetTypeManager->setOrder($order);

        // dd(Order::TARGET_TYPE_USER);

        // test getDefaultDriver.
        $model->target_type = Order::TARGET_TYPE_USER;
        $this->assertSame(Order::TARGET_TYPE_USER, $targetTypeManager->getDefaultDriver());

        // test Order::TARGET_TYPE_USER Driver instance of.
        $this->assertInstanceOf(UserTarget::class, $targetTypeManager->driver(Order::TARGET_TYPE_USER));
    }
}
