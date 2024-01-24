<?php

namespace Tests\Domains\Payment\Application\Commands\Save;

use App\Domains\Payment\Application\Commands\Save\SaveCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveCommandTest extends TestCase
{
    #[Test]
    public function testConstructionAndGetters()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        // Act
        $command = new SaveCommand($uuid, $projection);

        // Assert
        $this->assertInstanceOf(SaveCommand::class, $command);
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
