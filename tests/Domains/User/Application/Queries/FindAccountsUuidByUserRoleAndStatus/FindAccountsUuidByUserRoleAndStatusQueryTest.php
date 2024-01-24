<?php

namespace Tests\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus;

use App\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus\FindAccountsUuidByUserRoleAndStatusQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindAccountsUuidByUserRoleAndStatusQueryTest extends TestCase
{
    #[Test]
    public function testConstruction()
    {
        // Arrange
        $status = UserStatus::ACTIVE->value;
        $roles = [UserRole::ADMIN->value, UserRole::USER->value];

        // Act
        $query = new FindAccountsUuidByUserRoleAndStatusQuery($status, $roles);

        // Assert
        $this->assertEquals($status, $query->getStatus());
        $this->assertEquals($roles, $query->getRole());
    }
}
