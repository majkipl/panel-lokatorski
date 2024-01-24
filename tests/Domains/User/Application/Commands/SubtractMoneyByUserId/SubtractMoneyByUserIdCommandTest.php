<?php

namespace Tests\Domains\User\Application\Commands\SubtractMoneyByUserId;

use App\Domains\User\Application\Commands\SubtractMoneyByUserId\SubtractMoneyByUserIdCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubtractMoneyByUserIdCommandTest extends TestCase
{
    #[Test]
    public function testConstruction()
    {
        // Arrange
        $id = fake()->randomNumber();
        $amount = fake()->randomFloat(2);

        // Act
        $command = new SubtractMoneyByUserIdCommand($id, $amount);

        // Assert
        $this->assertInstanceOf(SubtractMoneyByUserIdCommand::class, $command);
        $this->assertEquals($id, $command->getId());
        $this->assertEquals($amount, $command->getAmount());
    }
}
