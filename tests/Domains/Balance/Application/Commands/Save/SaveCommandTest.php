<?php

namespace Tests\Domains\Balance\Application\Commands\Save;

use App\Domains\Balance\Application\Commands\Save\SaveCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveCommandTest extends TestCase
{
    #[Test]
    public function testConstructorAndGetters()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->word();

        // Act
        $command = new SaveCommand($uuid, $projection);

        // Assert the uuid is set correctly
        $this->assertEquals($uuid, $command->getUuid());

        // Assert the projection is set correctly
        $this->assertEquals($projection, $command->getProjection());
    }
}
