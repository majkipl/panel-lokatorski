<?php

namespace Tests\Domains\User\Application\Commands\SubtractMoneyByUserId;

use App\Domains\User\Application\Commands\SubtractMoneyByUserId\SubtractMoneyByUserIdCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SubtractMoneyByUserIdCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstruction()
    {
        $id = fake()->randomNumber();
        $amount = fake()->randomFloat(2);
        $command = new SubtractMoneyByUserIdCommand($id, $amount);

        $this->assertInstanceOf(SubtractMoneyByUserIdCommand::class, $command);
        $this->assertEquals($id, $command->getId());
        $this->assertEquals($amount, $command->getAmount());
    }
}
