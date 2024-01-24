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
        // Arrange
        $uuid = fake()->uuid();

        // Act
        $query = new FindLatestBillingByAccountUuidQuery($uuid);

        // Assert
        $this->assertEquals($uuid, $query->getUuid());
    }
}
