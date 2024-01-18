<?php

namespace Tests\Domains\User\Domain\Events;

use App\Domains\User\Domain\Events\AccountDeleted;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;

class AccountDeletedTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function accountDeletedEvent()
    {
        $accountUuid = fake()->uuid(); // Przykładowy UUID

        $event = new AccountDeleted($accountUuid);

        $this->assertEquals($accountUuid, $event->accountUuid);
    }
}
