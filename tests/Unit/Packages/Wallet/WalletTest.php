<?php



namespace Genv\Otc\Tests\Unit\Packages\Wallet;

use JsonSerializable;
use Genv\Otc\Tests\TestCase;
use Genv\Otc\Packages\Wallet\Wallet;
use Genv\Otc\Models\User as UserModel;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Genv\Otc\Models\NewWallet as WalletModel;

class WalletTest extends TestCase
{
    /**
     * Test Wallet::class implements.
     *
     * @return void
     */
    public function testClassImplements()
    {
        $wallet = new Wallet();
        $this->assertInstanceOf(Arrayable::class, $wallet);
        $this->assertInstanceOf(Jsonable::class, $wallet);
        $this->assertInstanceOf(JsonSerializable::class, $wallet);
    }

    /**
     * Test setUser method.
     *
     * @expectedException \Exception
     * @expectedExceptionMessage 传递的不是一个用户
     * @return void
     */
    public function testSetUser()
    {
        $user = factory(UserModel::class)->make();
        $user->id = 1;

        // Create a wallet mock.
        $wallet = $this->getMockBuilder(TestWalletSetUser::class)
                       ->setMethods(['userFindOrFail', 'resolveWallet'])
                       ->getMock();
        $wallet->expects($this->exactly(1))
               ->method('userFindOrFail')
               ->will($this->returnValue($user));
        $wallet->expects($this->exactly(2))
               ->method('resolveWallet')
               ->will($this->returnArgument(0));

        $wallet->setUser($user->id);
        $this->assertInstanceOf(UserModel::class, $wallet->getUser());
        $this->assertSame($user->id, $wallet->getUser()->id);

        $wallet->setUser($user);
        $this->assertSame($user->id, $wallet->getUser()->id);

        // @expectedException \Exception
        $wallet->setUser([]);
    }

    /**
     * Test getWalletModel method.
     *
     * @expectedException \Exception
     * @expectedExceptionMessage 没有设置钱包用户
     * @return void
     */
    public function testGetWalletModel()
    {
        $user = factory(UserModel::class)->make();
        $user->id = 1;

        // Create a wallet mock.
        $wallet = $this->getMockBuilder(Wallet::class)
                       ->setMethods(['walletFind'])
                       ->getMock();
        $wallet->expects($this->exactly(1))
               ->method('walletFind')
               ->willReturn(null);

        $wallet->setUser($user);
        $this->assertInstanceOf(WalletModel::class, $wallet->getWalletModel());

        // test exception.
        $wallet = new Wallet();
        $wallet->getWalletModel();
    }

    /**
     * Test increment method.
     *
     * @return void
     */
    public function testIncrement()
    {
        // Create a wallet model mock.
        $model = $this->getMockBuilder(WalletModel::class)
                      ->setMethods(['save'])
                      ->getMock();
        $model->expects($this->once())
              ->method('save')
              ->willReturn($model);

        // Create a Wallet mock.
        $wallet = $this->getMockBuilder(Wallet::class)
                       ->setMethods(['getWalletModel'])
                       ->getMock();
        $wallet->expects($this->exactly(3))
               ->method('getWalletModel')
               ->willReturn($model);

        $amount = 100;
        $wallet->increment($amount);

        $this->assertSame($amount, $wallet->getWalletModel()->balance);
        $this->assertSame($amount, $wallet->getWalletModel()->total_income);
    }

    /**
     * Test decrement method.
     *
     * @return void
     */
    public function testDecrement()
    {
        // Create a wallet model mock.
        $model = $this->getMockBuilder(WalletModel::class)
                      ->setMethods(['save'])
                      ->getMock();
        $model->expects($this->once())
              ->method('save')
              ->willReturn($model);

        // Create a Wallet mock.
        $wallet = $this->getMockBuilder(Wallet::class)
                       ->setMethods(['getWalletModel'])
                       ->getMock();
        $wallet->expects($this->exactly(3))
               ->method('getWalletModel')
               ->willReturn($model);

        $amount = 100;
        $wallet->decrement($amount);

        $this->assertSame(-$amount, $wallet->getWalletModel()->balance);
        $this->assertSame($amount, $wallet->getWalletModel()->total_expenses);
    }

    /**
     * Test enough method.
     *
     * @return void
     */
    public function testEnough()
    {
        $model = new WalletModel();
        $model->balance = 100;

        // Create a Wallet::class mock.
        $wallet = $this->getMockBuilder(Wallet::class)
                       ->setMethods(['getWalletModel'])
                       ->getMock();
        $wallet->expects($this->exactly(2))
               ->method('getWalletModel')
               ->willReturn($model);

        $this->assertTrue($wallet->enough(100));
        $this->assertFalse($wallet->enough(200));
    }

    /**
     * Test toArray method.
     *
     * @return void
     */
    public function testToArray()
    {
        $array = ['test' => true];

        // Create a WalletModel::class mock.
        $model = $this->getMockBuilder(WalletModel::class)
                      ->setMethods(['toArray'])
                      ->getMock();
        $model->expects($this->exactly(1))
              ->method('toArray')
              ->willReturn($array);

        // Create a Wallet::class mock.
        $wallet = $this->getMockBuilder(Wallet::class)
                       ->setMethods(['getWalletModel'])
                       ->getMock();
        $wallet->expects($this->exactly(1))
               ->method('getWalletModel')
               ->willReturn($model);

        $this->assertArraySubset($array, $wallet->toArray());
    }

    /**
     * Test jsonSerialize method.
     *
     * @return void
     */
    public function testJsonSerialize()
    {
        $array = ['test' => true];

        // Create a Wallet::class mock.
        $wallet = $this->getMockBuilder(Wallet::class)
                       ->setMethods(['toArray'])
                       ->getMock();
        $wallet->expects($this->exactly(1))
               ->method('toArray')
               ->willReturn($array);

        $this->assertArraySubset($array, $wallet->jsonSerialize());
    }

    /**
     * Test toJson method.
     *
     * @expectedException \RuntimeException
     * @return void
     */
    public function testToJson()
    {
        // 有效的
        $array = ['test' => true];

        // 无效的
        $text = "\xB1\x31";

        // Create a Wallet::class mock.
        $wallet = $this->getMockBuilder(Wallet::class)
                       ->setMethods(['jsonSerialize'])
                       ->getMock();
        $wallet->expects($this->exactly(2))
               ->method('jsonSerialize')
               ->will($this->onConsecutiveCalls($array, $text));

        $result = $wallet->toJson(0);
        // dd($result);
        $this->assertSame(json_encode($array, 0), $result);

        // Test exception
        $wallet->toJson();
    }

    /**
     * Test __toString method.
     *
     * @return void
     */
    public function test__toString()
    {
        $text = 'genvotc Plus';
        // Create a Wallet::class mock.
        $wallet = $this->getMockBuilder(Wallet::class)
                       ->setMethods(['toJson'])
                       ->getMock();
        $wallet->expects($this->exactly(1))
               ->method('toJson')
               ->willReturn($text);

        $this->assertSame($text, (string) $wallet);
    }
}

class TestWalletSetUser extends Wallet
{
    public function getUser()
    {
        return $this->user;
    }
}
