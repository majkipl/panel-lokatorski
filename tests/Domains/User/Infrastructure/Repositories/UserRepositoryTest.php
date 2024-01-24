<?php

namespace Tests\Domains\User\Infrastructure\Repositories;

use App\Domains\User\Application\DTO\UserDTO;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Models\Account;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Infrastructure\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testGetAllUsers()
    {
        // Arrange
        $mock = Mockery::mock(User::class);
        $mock->shouldReceive('all')->once()->andReturn(new Collection([]));
        $this->app->instance(User::class, $mock);

        $classUnderTest = new UserRepository($mock);

        // Act
        $result = $classUnderTest->getAllUsers();

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
    }

    #[Test]
    public function testGetUsersByStatusAndRole()
    {
        // Arrange
        $role = [UserRole::ADMIN->value, UserRole::USER->value];

        $mock = Mockery::mock(User::class);
        $mock->shouldReceive('when')
            ->withArgs(function ($status) {
                return !is_null($status);
            }, Mockery::on(function ($callback) {
                return is_callable($callback);
            }))
            ->andReturnSelf();

        $mock->shouldReceive('whereIn')
            ->with('role', $role)
            ->andReturnSelf();

        $mock->shouldReceive('get')
            ->once()
            ->andReturn(new Collection([]));

        $this->app->instance(User::class, $mock);

        $classUnderTest = new UserRepository($mock);

        // Act
        $result = $classUnderTest->getUsersByStatusAndRole($role, UserStatus::ACTIVE->value);

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
    }

    #[Test]
    public function testUpdateStatus()
    {
        // Arrange
        $user_id = fake()->randomNumber();
        $status = UserStatus::ACTIVE->value;
        $mock = Mockery::mock(User::class);
        $mock->shouldReceive('find')->with($user_id)->andReturnSelf();
        $mock->shouldReceive('save')->once()->andReturnTrue();
        $mock->shouldReceive('setAttribute')->withAnyArgs()->andReturnNull();
        $this->app->instance(User::class, $mock);

        $classUnderTest = new UserRepository($mock);

        // Act
        $result = $classUnderTest->updateStatus($user_id, $status);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function testGetAccountByUserId()
    {
        // Arrange
        $user_id = fake()->randomNumber();
        $accountMock = Mockery::mock(Account::class);
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('find')->with($user_id)->andReturnSelf();
        $userMock->shouldReceive('getAttribute')->with('account')->andReturn($accountMock);
        $this->app->instance(User::class, $userMock);

        $classUnderTest = new UserRepository($userMock);

        // Act
        $result = $classUnderTest->getAccountByUserId($user_id);

        // Assert
        $this->assertInstanceOf(Account::class, $result);
    }

    #[Test]
    public function testAddExpense()
    {
        // Arrange
        $user_id = fake()->randomNumber();
        $name = fake()->word();
        $amount = fake()->randomFloat(2);
        $accountMock = Mockery::mock(Account::class);
        $accountMock->shouldReceive('addExpense')->with($name, $amount)->once();
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('find')->with($user_id)->andReturnSelf();
        $userMock->shouldReceive('getAttribute')->with('account')->andReturn($accountMock);
        $this->app->instance(User::class, $userMock);

        $classUnderTest = new UserRepository($userMock);

        // Act
        $classUnderTest->addExpense($user_id, $name, $amount);

        // Assert
        $this->addToAssertionCount(Mockery::getContainer()->mockery_getExpectationCount());
    }

    #[Test]
    public function testAddMoney()
    {
        // Arrange
        $user_id = fake()->randomNumber();
        $amount = fake()->randomFloat(2);
        $accountMock = Mockery::mock(Account::class);
        $accountMock->shouldReceive('addMoney')->with($amount)->once();
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('find')->with($user_id)->andReturnSelf();
        $userMock->shouldReceive('getAttribute')->with('account')->andReturn($accountMock);
        $this->app->instance(User::class, $userMock);

        $classUnderTest = new UserRepository($userMock);

        // Act
        $classUnderTest->addMoney($user_id, $amount);

        // Assert
        $this->addToAssertionCount(Mockery::getContainer()->mockery_getExpectationCount());
    }

    #[Test]
    public function testSubtractMoney()
    {
        // Arrange
        $user_id = fake()->randomNumber();
        $amount = fake()->randomFloat(2);
        $accountMock = Mockery::mock(Account::class);
        $accountMock->shouldReceive('subtractMoney')->with($amount)->once();
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('find')->with($user_id)->andReturnSelf();
        $userMock->shouldReceive('getAttribute')->with('account')->andReturn($accountMock);
        $this->app->instance(User::class, $userMock);

        $classUnderTest = new UserRepository($userMock);

        // Act
        $classUnderTest->subtractMoney($user_id, $amount);

        // Assert
        $this->addToAssertionCount(Mockery::getContainer()->mockery_getExpectationCount());
    }

    #[Test]
    public function testCreateUser()
    {
        // Arrange
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('setAttribute')->withAnyArgs()->andReturnNull();
        $userMock->shouldReceive('save')->once()->andReturnTrue();
        $this->app->instance(User::class, $userMock);

        $dto = new UserDTO(
            email: fake()->safeEmail(),
            firstname: fake()->firstName(),
            lastname: fake()->lastName(),
            password: fake()->word(),
            status: UserStatus::ACTIVE,
            role: UserRole::USER,
        );

        $classUnderTest = new UserRepository($userMock);

        // Act
        $result = $classUnderTest->create($dto);

        // Assert
        $this->assertTrue($result);
    }
}
