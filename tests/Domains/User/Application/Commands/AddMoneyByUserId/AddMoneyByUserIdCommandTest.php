<?php

namespace Tests\Domains\User\Application\Commands\AddMoneyByUserId;

use App\Domains\User\Application\Commands\AddMoneyByUserId\AddMoneyByUserIdCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddMoneyByUserIdCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstruction()
    {
        $id = fake()->randomNumber();
        $amount = fake()->randomFloat(2);
        $command = new AddMoneyByUserIdCommand($id, $amount);

        $this->assertInstanceOf(AddMoneyByUserIdCommand::class, $command);
        $this->assertEquals($id, $command->getId());
        $this->assertEquals($amount, $command->getAmount());
    }
}
