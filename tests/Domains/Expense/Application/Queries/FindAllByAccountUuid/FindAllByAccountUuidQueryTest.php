<?php

namespace Tests\Domains\Expense\Application\Queries\FindAllByAccountUuid;

use App\Domains\Expense\Application\Queries\FindAllByAccountUuid\FindAllByAccountUuidQuery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindAllByAccountUuidQueryTest extends TestCase
{
    #[Test]
    public function testGetUuid()
    {
        // Arrange
        $uuid = fake()->uuid();

        // Act
        $query = new FindAllByAccountUuidQuery($uuid);

        // Assert
        $this->assertEquals($uuid, $query->getUuid());
    }
}
