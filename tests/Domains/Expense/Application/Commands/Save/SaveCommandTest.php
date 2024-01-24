<?php

namespace Tests\Domains\Expense\Application\Commands\Save;

use App\Domains\Expense\Application\Commands\Save\SaveCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveCommandTest extends TestCase
{
    #[Test]
    public function testConstructorAndGetters()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence(6);

        // Act
        $command = new SaveCommand($uuid, $projection);

        // Assert
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
