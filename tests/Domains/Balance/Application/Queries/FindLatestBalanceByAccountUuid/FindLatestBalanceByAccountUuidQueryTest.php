<?php

namespace Tests\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid;

use App\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid\FindLatestBalanceByAccountUuidQuery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindLatestBalanceByAccountUuidQueryTest extends TestCase
{
    #[Test]
    public function testGetUuid()
    {
        // Arrange
        $uuid = fake()->uuid();

        // Act
        $query = new FindLatestBalanceByAccountUuidQuery($uuid);

        // Assert
        $this->assertSame($uuid, $query->getUuid());
    }
}
