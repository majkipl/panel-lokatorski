<?php

namespace Tests\Domains\User\Application\Commands\CancelExpenseByAccountUuid;

use App\Domains\User\Application\Commands\CancelExpenseByAccountUuid\CancelExpenseByAccountUuidCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CancelExpenseByAccountUuidCommandTest extends TestCase
{
    #[Test]
    public function testConstruction()
    {
        // Arrange
        $uuid = fake()->uuid();
        $id = fake()->randomNumber();

        // Act
        $command = new CancelExpenseByAccountUuidCommand($uuid, $id);

        // Assert
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($id, $command->getId());
    }
}
