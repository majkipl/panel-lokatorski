<?php

namespace Tests\Domains\User\Application\Commands\AddExpenseByUserId;

use App\Domains\User\Application\Commands\AddExpenseByUserId\AddExpenseByUserIdCommand;
use App\Domains\User\Domain\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AddExpenseByUserIdCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstruction()
    {
        $user = User::factory()->create();
        $name = fake()->word();
        $amount = fake()->randomFloat(2);

        $command = new AddExpenseByUserIdCommand($user->id, $name, $amount);

        $this->assertEquals($user->id, $command->getId());
        $this->assertEquals($name, $command->getName());
        $this->assertEquals($amount, $command->getAmount());
    }
}
