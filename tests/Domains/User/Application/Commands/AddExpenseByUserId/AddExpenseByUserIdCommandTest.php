<?php

namespace Tests\Domains\User\Application\Commands\AddExpenseByUserId;

use App\Domains\User\Application\Commands\AddExpenseByUserId\AddExpenseByUserIdCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddExpenseByUserIdCommandTest extends TestCase
{
    #[Test]
    public function testConstruction()
    {
        // Arrange
        $user = fake()->randomNumber();
        $name = fake()->word();
        $amount = fake()->randomFloat(2);

        // Act
        $command = new AddExpenseByUserIdCommand($user, $name, $amount);

        // Assert
        $this->assertEquals($user, $command->getId());
        $this->assertEquals($name, $command->getName());
        $this->assertEquals($amount, $command->getAmount());
    }
}
