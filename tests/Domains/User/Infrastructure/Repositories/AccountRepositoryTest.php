<?php

namespace Tests\Domains\User\Infrastructure\Repositories;

use App\Domains\User\Domain\Models\Account;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Infrastructure\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountRepositoryTest extends TestCase
{
    use DatabaseTransactions;
    #[Test]
    public function testCancelExpense()
    {
        // Arrange
        $accountMock = Mockery::mock(Account::class);
        $accountMock->shouldReceive('cancelExpense')->with(1)->once();
        $userMock = Mockery::mock(Account::class);
        $userMock->shouldReceive('where')->with('uuid', 'uuid')->andReturnSelf();
        $userMock->shouldReceive('first')->andReturn($accountMock);
        $this->app->instance(Account::class, $userMock);
        $accountRepo = new AccountRepository($userMock);

        // Act
        $accountRepo->cancelExpense('uuid', 1);

        // Assert
        $this->addToAssertionCount(Mockery::getContainer()->mockery_getExpectationCount());
    }

    #[Test]
    public function testGetUserByAccountUuid()
    {
        // Arrange
        $userMock = Mockery::mock(User::class);
        $accountMock = Mockery::mock(Account::class);
        $accountMock->shouldReceive('where')->with('uuid', 'uuid')->andReturnSelf();
        $accountMock->shouldReceive('with')->with('user:id,firstname,lastname,email,created_at')->andReturnSelf();
        $accountMock->shouldReceive('first')->andReturnSelf();
        $accountMock->shouldReceive('getAttribute')->with('user')->andReturn($userMock);
        $this->app->instance(Account::class, $accountMock);
        $accountRepo = new AccountRepository($accountMock);

        // Act
        $result = $accountRepo->getUserByAccountUuid('uuid');

        // Assert
        $this->assertInstanceOf(User::class, $result);
    }

    #[Test]
    public function testGetAccountByUserRoleAndStatus()
    {
        // Arrange
        $accountMock = Mockery::mock(Account::class);
        $accountMock->shouldReceive('whereHas->get')->once()->andReturn(new Collection());
        $this->app->instance(Account::class, $accountMock);
        $accountRepo = new AccountRepository($accountMock);

        // Act
        $result = $accountRepo->getAccountByUserRoleAndStatus('status', ['role']);

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
    }

    #[Test]
    public function testIsExistAccountByUserId()
    {
        // Arrange
        $accountMock = Mockery::mock(Account::class);
        $accountMock->shouldReceive('where')->with('user_id', 1)->andReturnSelf();
        $accountMock->shouldReceive('exists')->andReturn(true);
        $this->app->instance(Account::class, $accountMock);
        $accountRepo = new AccountRepository($accountMock);

        // Act
        $result = $accountRepo->isExistAccountByUserId(1);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function testSave()
    {
        // Arrange
        $accountMock = Mockery::mock(Account::class);
        $accountMock->shouldReceive('writeable')->andReturnSelf();
        $accountMock->shouldReceive('save')->andReturn(true);
        $this->app->instance(Account::class, $accountMock);
        $accountRepo = new AccountRepository($accountMock);

        // Act
        $result = $accountRepo->save(['balance' => 1000, 'user_id' => 1]);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function testUpdateBalanceByUserId()
    {
        // Arrange
        $accountMock = Mockery::mock(Account::class);
        $accountMock->shouldReceive('where')->with('user_id', 1)->andReturnSelf();
        $accountMock->shouldReceive('first')->andReturnSelf();
        $accountMock->shouldReceive('setAttribute')->with('balance', 2000)->andReturnSelf();
        $accountMock->shouldReceive('writeable')->andReturnSelf();
        $accountMock->shouldReceive('save')->andReturn(true);
        $this->app->instance(Account::class, $accountMock);
        $accountRepo = new AccountRepository($accountMock);

        // Act
        $result = $accountRepo->updateBalanceByUserId(1, 2000);

        // Assert
        $this->assertTrue($result);
    }
}
