<?php

namespace Tests\Domains\User\Application\Commands\SubtractMoneyByUserId;

use App\Domains\User\Application\Commands\SubtractMoneyByUserId\SubtractMoneyByUserIdCommand;
use App\Domains\User\Application\Commands\SubtractMoneyByUserId\SubtractMoneyByUserIdHandler;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SubtractMoneyByUserIdHandlerTest extends TestCase
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
            ->method('subtractMoney')
            ->with(
                $this->equalTo($user->id),  // Example user ID
                $this->equalTo($amount) // Example amount
            );

        // Create SubtractMoneyByUserIdHandler instance with mocked repository
        $handler = new SubtractMoneyByUserIdHandler($userRepositoryMock);

        // Create example command
        $command = new SubtractMoneyByUserIdCommand($user->id, $amount);

        // Call handle method
        $handler->handle($command);
    }
}
