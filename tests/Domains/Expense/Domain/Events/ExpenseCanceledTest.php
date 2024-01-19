<?php

namespace Tests\Domains\Expense\Domain\Events;

use App\Domains\Expense\Domain\Events\ExpenseCanceled;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExpenseCanceledTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testConstructor()
    {
        $accountUuid = fake()->uuid();
        $name = fake()->word();
        $amount = fake()->randomFloat(2);
        $participants = [fake()->uuid(), fake()->uuid(), fake()->uuid()];
        $eventId = fake()->randomNumber();

        // Create ExpenseCanceled event instance
        $event = new ExpenseCanceled($accountUuid, $name, $amount, $eventId, $participants);

        // Assert that the properties are set correctly
        $this->assertEquals($accountUuid, $event->accountUuid);
        $this->assertEquals($name, $event->name);
        $this->assertEquals($amount, $event->amount);
        $this->assertEquals($eventId, $event->eventId);
        $this->assertEquals($participants, $event->participants);
    }
}
