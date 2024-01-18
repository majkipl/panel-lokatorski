<?php

namespace Tests\Domains\User\Application\Commands\UpdateUserStatus;

use App\Domains\User\Application\Commands\UpdateUserStatus\UpdateUserStatusCommand;
use App\Domains\User\Application\Commands\UpdateUserStatus\UpdateUserStatusHandler;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateUserStatusHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        // Mock UserRepositoryInterface
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        $user = User::factory()->create();

        // Set up expectations
        $userRepositoryMock->expects($this->once())
            ->method('updateStatus')
            ->with(
                $this->equalTo($user->id),    // Example user ID
                $this->equalTo(UserStatus::ACTIVE->value) // Example status
            )
            ->willReturn(true); // Example return value

        // Create UpdateUserStatusHandler instance with mocked repository
        $handler = new UpdateUserStatusHandler($userRepositoryMock);

        // Create example command
        $command = new UpdateUserStatusCommand($user->id, UserStatus::ACTIVE->value);

        // Call handle method and assert the return value
        $this->assertTrue($handler->handle($command));
    }
}
