<?php

namespace Tests\Domains\Expense\Domain\Events;

use App\Domains\Expense\Domain\Events\ExpenseAdded;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExpenseAddedTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testConstructor()
    {
        // Test data
        $accountUuid = 'example_account_uuid';
        $name = fake()->word();
        $amount = fake()->randomFloat(2);
        $participants = [fake()->uuid(), fake()->uuid(), fake()->uuid()];

        // Create ExpenseAdded event instance
        $event = new ExpenseAdded($accountUuid, $name, $amount, $participants);

        // Assert that the properties are set correctly
        $this->assertEquals($accountUuid, $event->accountUuid);
        $this->assertEquals($name, $event->name);
        $this->assertEquals($amount, $event->amount);
        $this->assertEquals($participants, $event->participants);
    }
}
