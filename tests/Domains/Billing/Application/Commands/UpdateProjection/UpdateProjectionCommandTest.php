<?php

namespace Tests\Domains\Billing\Application\Commands\UpdateProjection;

use App\Domains\Billing\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionCommandTest extends TestCase
{
    #[Test]
    public function testConstructorAndGetters()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        // Act
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Assert
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
