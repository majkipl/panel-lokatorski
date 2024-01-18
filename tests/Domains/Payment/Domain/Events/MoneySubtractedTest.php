<?php

namespace Tests\Domains\Payment\Domain\Events;

use App\Domains\Payment\Domain\Events\MoneySubtracted;
use Tests\TestCase;

class MoneySubtractedTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstruction()
    {
        $accountUuid = fake()->uuid();
        $amount = fake()->randomFloat(2);

        $event = new MoneySubtracted($accountUuid, $amount);

        $this->assertInstanceOf(MoneySubtracted::class, $event);
        $this->assertEquals($accountUuid, $event->accountUuid);
        $this->assertEquals($amount, $event->amount);
    }
}
