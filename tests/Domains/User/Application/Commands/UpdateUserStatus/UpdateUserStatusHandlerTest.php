<?php

namespace Tests\Domains\User\Application\Commands\UpdateUserStatus;

use App\Domains\User\Application\Commands\UpdateUserStatus\UpdateUserStatusCommand;
use App\Domains\User\Application\Commands\UpdateUserStatus\UpdateUserStatusHandler;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateUserStatusHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $id = fake()->randomNumber();
        $status = UserStatus::random()->value;
        $command = new UpdateUserStatusCommand($id, $status);
        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $repositoryMock->shouldReceive('updateStatus')->with($id, $status)->andReturn(true);
        $handler = new UpdateUserStatusHandler($repositoryMock);

        // Act
        $result = $handler->handle($command);

        // Assert
        $this->assertTrue($result);
    }
}
