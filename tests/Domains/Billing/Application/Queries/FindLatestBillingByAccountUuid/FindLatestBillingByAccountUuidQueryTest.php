<?php

namespace Tests\Domains\Billing\Application\Queries\FindLatestBillingByAccountUuid;

use App\Domains\Billing\Application\Queries\FindLatestBillingByAccountUuid\FindLatestBillingByAccountUuidQuery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindLatestBillingByAccountUuidQueryTest extends TestCase
{
    #[Test]
    public function testConstructor()
    {
        $uuid = fake()->uuid();
        // Create an instance of the query
        $query = new FindLatestBillingByAccountUuidQuery($uuid);

        // Assert the UUID is set correctly
        $this->assertEquals($uuid, $query->getUuid());
    }
}
