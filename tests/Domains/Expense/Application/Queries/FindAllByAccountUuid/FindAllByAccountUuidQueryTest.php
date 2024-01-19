<?php

namespace Tests\Domains\Expense\Application\Queries\FindAllByAccountUuid;

use App\Domains\Expense\Application\Queries\FindAllByAccountUuid\FindAllByAccountUuidQuery;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindAllByAccountUuidQueryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testGetUuid()
    {
        // UUID example
        $uuid = fake()->uuid();

        // Create FindAllByAccountUuidQuery instance
        $query = new FindAllByAccountUuidQuery($uuid);

        // Call getUuid method and assert that it returns the same UUID
        $this->assertEquals($uuid, $query->getUuid());
    }
}
