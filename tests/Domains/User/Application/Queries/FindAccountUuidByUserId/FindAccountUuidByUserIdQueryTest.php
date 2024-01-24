<?php

namespace Tests\Domains\User\Application\Queries\FindAccountUuidByUserId;

use App\Domains\User\Application\Queries\FindAccountUuidByUserId\FindAccountUuidByUserIdQuery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindAccountUuidByUserIdQueryTest extends TestCase
{
    #[Test]
    public function testConstructor()
    {
        // Arrange
        $userId = fake()->randomNumber();

        // Act
        $query = new FindAccountUuidByUserIdQuery($userId);

        // Assert
        $this->assertEquals($userId, $query->getId());
    }
}
