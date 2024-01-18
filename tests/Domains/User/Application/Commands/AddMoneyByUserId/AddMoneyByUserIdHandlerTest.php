<?php

namespace Tests\Domains\User\Application\Commands\AddMoneyByUserId;

use App\Domains\User\Application\Commands\AddMoneyByUserId\AddMoneyByUserIdCommand;
use App\Domains\User\Application\Commands\AddMoneyByUserId\AddMoneyByUserIdHandler;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddMoneyByUserIdHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        // Mock UserRepositoryInterface
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        $user = User::factory()->create();
        $amount = fake()->randomFloat(2);

        // Set up expectations
        $userRepositoryMock->expects($this->once())
            ->method('addMoney')
            ->with(
                $this->equalTo($user->id),  // Example user ID
                $this->equalTo($amount) // Example amount
            );

        // Create AddMoneyByUserIdHandler instance with mocked repository
        $handler = new AddMoneyByUserIdHandler($userRepositoryMock);

        // Create example command
        $command = new AddMoneyByUserIdCommand($user->id, $amount);

        // Call handle method
        $handler->handle($command);
    }
}
