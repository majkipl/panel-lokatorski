<?php

namespace Tests\Domains\Payment\Domain\Events;

use App\Domains\Payment\Domain\Events\MoneyAdded;
use Tests\TestCase;

class MoneyAddedTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstruction()
    {
        $accountUuid = fake()->uuid();
        $amount = fake()->randomFloat(2);

        $event = new MoneyAdded($accountUuid, $amount);

        $this->assertInstanceOf(MoneyAdded::class, $event);
        $this->assertEquals($accountUuid, $event->accountUuid);
        $this->assertEquals($amount, $event->amount);
    }
}
