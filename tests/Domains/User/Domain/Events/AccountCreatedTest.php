<?php

namespace Tests\Domains\User\Domain\Events;

use App\Domains\User\Domain\Events\AccountCreated;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;

class AccountCreatedTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testAccountCreatedEvent()
    {
        $accountAttributes = [
            'user_id' => fake()->randomNumber(),
        ];

        $event = new AccountCreated($accountAttributes);

        $this->assertEquals($accountAttributes, $event->accountAttributes);
    }
}
