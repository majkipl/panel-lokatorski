<?php

namespace Tests\Domains\Expense\Application\Commands\UpdateProjection;

use App\Domains\Expense\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionCommandTest extends TestCase
{
    #[Test]
    public function testConstructorAndMethods()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence(6);

        // Act
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Assert
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
