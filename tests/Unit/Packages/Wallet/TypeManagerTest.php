<?php



namespace Genv\Otc\Tests\Unit\Packages\Wallet;

use Genv\Otc\Tests\TestCase;
use Genv\Otc\Packages\Wallet\Order;
use Genv\Otc\Packages\Wallet\TypeManager;
use Genv\Otc\Packages\Wallet\Types\UserType;

class TypeManagerTest extends TestCase
{
    protected $typeManager;

    /**
     * Setup the test environment.
     *
     * @author Seven Du <shiweidu@outlook.com>
     */
    protected function setUp()
    {
        parent::setUp();

        $this->typeManager = $this->app->make(TypeManager::class);
    }

    /**
     * Test get default driver return.
     *
     * @return void
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function testGetDefaultDriver()
    {
        $defaultDriverString = $this->typeManager->getDefaultDriver();
        $this->assertSame(Order::TARGET_TYPE_USER, $defaultDriverString);
    }

    /**
     * Test Create user driver.
     *
     * @return void
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function testCreateUserDriver()
    {
        $userType = $this->typeManager->driver(Order::TARGET_TYPE_USER);

        $this->assertInstanceOf(UserType::class, $userType);
    }
}
