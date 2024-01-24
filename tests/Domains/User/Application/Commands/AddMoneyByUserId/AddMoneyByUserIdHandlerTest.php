<?php

namespace Tests\Domains\User\Application\Commands\AddMoneyByUserId;

use App\Domains\User\Application\Commands\AddMoneyByUserId\AddMoneyByUserIdCommand;
use App\Domains\User\Application\Commands\AddMoneyByUserId\AddMoneyByUserIdHandler;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddMoneyByUserIdHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $id = fake()->randomNumber();
        $amount = fake()->randomFloat();
        $command = new AddMoneyByUserIdCommand($id, $amount);
        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $repositoryMock->shouldReceive('addMoney')->with($id, $amount)->once();
        $handler = new AddMoneyByUserIdHandler($repositoryMock);

        // Act
        $handler->handle($command);

        // Assert
        // As the handle method does not return a value, we can only assert that no exceptions were thrown
        $this->addToAssertionCount(1);
    }
}
