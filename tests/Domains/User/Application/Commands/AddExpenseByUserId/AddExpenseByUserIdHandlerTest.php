<?php

namespace Tests\Domains\User\Application\Commands\AddExpenseByUserId;

use App\Domains\User\Application\Commands\AddExpenseByUserId\AddExpenseByUserIdCommand;
use App\Domains\User\Application\Commands\AddExpenseByUserId\AddExpenseByUserIdHandler;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddExpenseByUserIdHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        // Mock UserRepositoryInterface
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        $user = User::factory()->create();
        $name = fake()->word();
        $amount = fake()->randomFloat(2);

        // Set up expectation for addExpense method in UserRepositoryInterface
        $userRepositoryMock->expects($this->once())
            ->method('addExpense')
            ->with(
                $this->equalTo($user->id), // ID
                $this->equalTo($name), // Name
                $this->equalTo($amount) // Amount
            );

        // Create AddExpenseByUserIdHandler instance with mocked UserRepositoryInterface
        $handler = new AddExpenseByUserIdHandler($userRepositoryMock);

        // Create AddExpenseByUserIdCommand instance
        $command = new AddExpenseByUserIdCommand($user->id, $name, $amount);

        // Call handle method
        $handler->handle($command);
    }
}
