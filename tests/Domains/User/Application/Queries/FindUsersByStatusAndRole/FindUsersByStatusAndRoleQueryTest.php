<?php

namespace Tests\Domains\User\Application\Queries\FindUsersByStatusAndRole;

use App\Domains\User\Application\Queries\FindUsersByStatusAndRole\FindUsersByStatusAndRoleQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindUsersByStatusAndRoleQueryTest extends TestCase
{
    #[Test]
    public function testConstruction()
    {
        // Arrange
        $roles = [UserRole::ADMIN->value, UserRole::USER->value];
        $status = UserStatus::ACTIVE->value;

        // Act
        $query = new FindUsersByStatusAndRoleQuery($roles, $status);

        // Assert
        $this->assertInstanceOf(FindUsersByStatusAndRoleQuery::class, $query);
        $this->assertEquals($roles, $query->getRole());
        $this->assertEquals($status, $query->getStatus());
    }
}
