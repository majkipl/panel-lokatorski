<?php

namespace Tests\Domains\User\Application\Queries\IsThereAccountByUserId;

use App\Domains\User\Application\Queries\IsThereAccountByUserId\IsThereAccountByUserIdQuery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IsThereAccountByUserIdQueryTest extends TestCase
{
    #[Test]
    public function testGetId()
    {
        // Arrange
        $id = 1;
        $query = new IsThereAccountByUserIdQuery($id);

        // Act
        $result = $query->getId();

        // Assert
        $this->assertEquals($id, $result);
    }
}
