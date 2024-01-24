<?php

namespace Tests\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus;

use App\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus\FindEmailsByUserRoleAndStatusQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindEmailsByUserRoleAndStatusQueryTest extends TestCase
{
    #[Test]
    public function testValidQueryCreation()
    {
        // Arrange
        $status = UserStatus::ACTIVE;
        $roles = [UserRole::ADMIN, UserRole::USER];

        // Act
        $query = new FindEmailsByUserRoleAndStatusQuery(
            status: $status,
            role: $roles
        );

        // Assert
        $this->assertInstanceOf(FindEmailsByUserRoleAndStatusQuery::class, $query);
    }

    #[Test]
    public function testInvalidQueryCreationWithInvalidRole()
    {
        // Arrange
        $status = UserStatus::ACTIVE;
        $invalidRoles = ['invalid_role'];

        // Act & Assert
        $this->expectException(InvalidArgumentException::class);

        new FindEmailsByUserRoleAndStatusQuery(
            status: $status,
            role: $invalidRoles
        );
    }

    #[Test]
    public function testGetStatus()
    {
        // Arrange
        $status = UserStatus::ACTIVE;
        $roles = [UserRole::ADMIN, UserRole::USER];
        $query = new FindEmailsByUserRoleAndStatusQuery(
            status: $status,
            role: $roles
        );

        // Act
        $result = $query->getStatus();

        // Assert
        $this->assertInstanceOf(UserStatus::class, $result);
        $this->assertEquals($status, $result);
    }

    #[Test]
    public function testGetRole()
    {
        // Arrange
        $status = UserStatus::ACTIVE;
        $roles = [UserRole::ADMIN, UserRole::USER];
        $query = new FindEmailsByUserRoleAndStatusQuery(
            status: $status,
            role: $roles
        );

        // Act
        $result = $query->getRole();

        // Assert
        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        foreach ($result as $role) {
            $this->assertNotNull(UserRole::tryFrom($role));
        }
    }
}
