<?php

namespace Tests\Domains\User\Application\Queries\FindAccountUuidByUserId;

use App\Domains\User\Application\Queries\FindAccountUuidByUserId\FindAccountUuidByUserIdQuery;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FindAccountUuidByUserIdQueryTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstructor()
    {
        $userId = fake()->randomNumber();

        // Create FindAccountUuidByUserIdQuery instance
        $query = new FindAccountUuidByUserIdQuery($userId);

        // Check if ID is set correctly
        $this->assertEquals($userId, $query->getId());
    }
}
