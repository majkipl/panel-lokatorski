<?php

namespace Tests\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid;

use App\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid\FindLatestPaymentByAccountUuidQuery;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FindLatestPaymentByAccountUuidQueryTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstructionAndGetters()
    {
        $uuid = fake()->uuid();

        $query = new FindLatestPaymentByAccountUuidQuery($uuid);

        $this->assertInstanceOf(FindLatestPaymentByAccountUuidQuery::class, $query);
        $this->assertEquals($uuid, $query->getUuid());
    }
}
