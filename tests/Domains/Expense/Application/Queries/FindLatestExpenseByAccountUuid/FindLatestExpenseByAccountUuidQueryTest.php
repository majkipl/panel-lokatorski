<?php

namespace Tests\Domains\Expense\Application\Queries\FindLatestExpenseByAccountUuid;

use App\Domains\Expense\Application\Queries\FindLatestExpenseByAccountUuid\FindLatestExpenseByAccountUuidQuery;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindLatestExpenseByAccountUuidQueryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testConstruct()
    {
        // UUID example
        $uuid = fake()->uuid();

        // Create FindLatestExpenseByAccountUuidQuery instance
        $query = new FindLatestExpenseByAccountUuidQuery($uuid);

        // Assert that the query UUID is set correctly
        $this->assertEquals($uuid, $query->getUuid());
    }
}
