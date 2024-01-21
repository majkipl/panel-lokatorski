<?php

namespace Tests\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid;

use App\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid\FindLatestBalanceByAccountUuidQuery;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindLatestBalanceByAccountUuidQueryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testGetUuid()
    {
        // Given
        $uuid = fake()->uuid();

        // When
        $query = new FindLatestBalanceByAccountUuidQuery($uuid);

        // Then
        $this->assertSame($uuid, $query->getUuid());
    }
}
