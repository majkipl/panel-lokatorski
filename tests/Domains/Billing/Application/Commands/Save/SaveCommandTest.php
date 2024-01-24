<?php

namespace Tests\Domains\Billing\Application\Commands\Save;

use App\Domains\Billing\Application\Commands\Save\SaveCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveCommandTest extends TestCase
{
    #[Test]
    public function testConstructor()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        // Act
        $command = new SaveCommand($uuid, $projection);

        // Assert
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
