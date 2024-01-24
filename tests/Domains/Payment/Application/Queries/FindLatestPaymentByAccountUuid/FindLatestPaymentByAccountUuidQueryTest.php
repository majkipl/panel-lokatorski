<?php

namespace Tests\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid;

use App\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid\FindLatestPaymentByAccountUuidQuery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindLatestPaymentByAccountUuidQueryTest extends TestCase
{
    #[Test]
    public function testConstructionAndGetters()
    {
        // Arrange
        $uuid = fake()->uuid();

        // Act
        $query = new FindLatestPaymentByAccountUuidQuery($uuid);

        // Assert
        $this->assertInstanceOf(FindLatestPaymentByAccountUuidQuery::class, $query);
        $this->assertEquals($uuid, $query->getUuid());
    }
}
