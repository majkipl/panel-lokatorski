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
        // Arrange
        $uuid = fake()->uuid();

        // Act
        $query = new FindLatestExpenseByAccountUuidQuery($uuid);

        // Assert
        $this->assertEquals($uuid, $query->getUuid());
    }
}
