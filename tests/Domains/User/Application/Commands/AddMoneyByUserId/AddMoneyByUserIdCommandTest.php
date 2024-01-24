<?php

namespace Tests\Domains\User\Application\Commands\AddMoneyByUserId;

use App\Domains\User\Application\Commands\AddMoneyByUserId\AddMoneyByUserIdCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddMoneyByUserIdCommandTest extends TestCase
{
    #[Test]
    public function testConstruction()
    {
        // Arrange
        $id = fake()->randomNumber();
        $amount = fake()->randomFloat(2);

        // Act
        $command = new AddMoneyByUserIdCommand($id, $amount);

        // Assert
        $this->assertInstanceOf(AddMoneyByUserIdCommand::class, $command);
        $this->assertEquals($id, $command->getId());
        $this->assertEquals($amount, $command->getAmount());
    }
}
