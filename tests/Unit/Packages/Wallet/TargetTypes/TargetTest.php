<?php



namespace Genv\Otc\Tests\Unit\Packages\Wallet\TargetTypes;

use Genv\Otc\Tests\TestCase;
use Genv\Otc\Packages\Wallet\Order;
use Genv\Otc\Packages\Wallet\TargetTypes\Target;

class TargetTest extends TestCase
{
    /**
     * Test target setOrder method.
     *
     * @return void
     */
    public function testSetOrder()
    {
        $target = $this->getMockForAbstractClass(TestTargetClass::class);
        $order = $this->createMock(Order::class);

        $target->setOrder($order);
        $this->assertSame($order, $target->getOrder());
    }
}

abstract class TestTargetClass extends Target
{
    public function getOrder()
    {
        return $this->order;
    }
}
