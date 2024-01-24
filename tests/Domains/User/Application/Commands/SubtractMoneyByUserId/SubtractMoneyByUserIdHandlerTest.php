<?php

namespace Tests\Domains\User\Application\Commands\SubtractMoneyByUserId;

use App\Domains\User\Application\Commands\SubtractMoneyByUserId\SubtractMoneyByUserIdCommand;
use App\Domains\User\Application\Commands\SubtractMoneyByUserId\SubtractMoneyByUserIdHandler;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubtractMoneyByUserIdHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $id = fake()->randomNumber();
        $amount = fake()->randomFloat();
        $command = new SubtractMoneyByUserIdCommand($id, $amount);
        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $repositoryMock->shouldReceive('subtractMoney')->with($id, $amount)->once();
        $handler = new SubtractMoneyByUserIdHandler($repositoryMock);

        // Act
        $handler->handle($command);

        // Assert
        // As the handle method does not return a value, we can only assert that no exceptions were thrown
        $this->addToAssertionCount(1);
    }
}
