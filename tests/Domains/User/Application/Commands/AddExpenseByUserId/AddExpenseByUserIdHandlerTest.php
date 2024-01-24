<?php

namespace Tests\Domains\User\Application\Commands\AddExpenseByUserId;

use App\Domains\User\Application\Commands\AddExpenseByUserId\AddExpenseByUserIdCommand;
use App\Domains\User\Application\Commands\AddExpenseByUserId\AddExpenseByUserIdHandler;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddExpenseByUserIdHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $id = fake()->randomNumber();
        $name = fake()->word();
        $amount = fake()->randomFloat();
        $command = new AddExpenseByUserIdCommand($id, $name, $amount);
        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $repositoryMock->shouldReceive('addExpense')->with($id, $name, $amount)->once();
        $handler = new AddExpenseByUserIdHandler($repositoryMock);

        // Act
        $handler->handle($command);

        // Assert
        // As the handle method does not return a value, we can only assert that no exceptions were thrown
        $this->addToAssertionCount(1);
    }
}
