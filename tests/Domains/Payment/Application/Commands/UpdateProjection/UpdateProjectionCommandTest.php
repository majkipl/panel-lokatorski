<?php

namespace Tests\Domains\Payment\Application\Commands\UpdateProjection;

use App\Domains\Payment\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionCommandTest extends TestCase
{
    #[Test]
    public function testConstructionAndGetters()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        // Act
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Assert
        $this->assertInstanceOf(UpdateProjectionCommand::class, $command);
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
