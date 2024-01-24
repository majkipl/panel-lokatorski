<?php

namespace Tests\Domains\Balance\Application\Commands\UpdateProjection;

use App\Domains\Balance\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionCommandTest extends TestCase
{
    #[Test]
    public function testGetters()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->word();

        // Act
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Assert
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
