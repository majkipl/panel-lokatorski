<?php

namespace Tests\Domains\User\Application\Queries\FindUserByAccountUuid;

use App\Domains\User\Application\Queries\FindUserByAccountUuid\FindUserByAccountUuidQuery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindUserByAccountUuidQueryTest extends TestCase
{
    #[Test]
    public function testConstruction()
    {
        // Arrange
        $uuid = fake()->uuid();

        // Act
        $query = new FindUserByAccountUuidQuery($uuid);

        // Assert
        $this->assertInstanceOf(FindUserByAccountUuidQuery::class, $query);
        $this->assertEquals($uuid, $query->getUuid());
    }
}
