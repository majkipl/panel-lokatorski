<?php

namespace Tests\Domains\User\Application\Commands\UpdateUserStatus;

use App\Domains\User\Application\Commands\UpdateUserStatus\UpdateUserStatusCommand;
use App\Domains\User\Domain\Enums\UserStatus;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateUserStatusCommandTest extends TestCase
{
    #[Test]
    public function testConstruction()
    {
        // Arrange
        $id = fake()->randomNumber();
        $status = UserStatus::ACTIVE->value;

        // Act
        $command = new UpdateUserStatusCommand($id, $status);

        // Assert
        $this->assertInstanceOf(UpdateUserStatusCommand::class, $command);
        $this->assertEquals($id, $command->getId());
        $this->assertEquals($status, $command->getStatus());
    }
}
