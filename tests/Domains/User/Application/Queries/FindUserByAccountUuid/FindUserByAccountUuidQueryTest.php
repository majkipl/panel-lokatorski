<?php

namespace Tests\Domains\User\Application\Queries\FindUserByAccountUuid;

use App\Domains\User\Application\Queries\FindUserByAccountUuid\FindUserByAccountUuidQuery;
use Tests\TestCase;

class FindUserByAccountUuidQueryTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstruction()
    {
        $uuid = fake()->uuid();
        $query = new FindUserByAccountUuidQuery($uuid);

        $this->assertInstanceOf(FindUserByAccountUuidQuery::class, $query);
        $this->assertEquals($uuid, $query->getUuid());
    }
}
