<?php

namespace Tests\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus;

use App\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus\FindEmailsByUserRoleAndStatusQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindEmailsByUserRoleAndStatusQueryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testValidQueryCreation()
    {
        // Given
        $status = UserStatus::ACTIVE;
        $roles = [UserRole::ADMIN, UserRole::USER];

        // When
        $query = new FindEmailsByUserRoleAndStatusQuery(
            status: $status,
            role: $roles
        );

        // Then
        $this->assertInstanceOf(FindEmailsByUserRoleAndStatusQuery::class, $query);
    }

    #[Test]
    public function testInvalidQueryCreationWithInvalidRole()
    {
        // Given
        $status = UserStatus::ACTIVE;
        $invalidRoles = ['invalid_role'];

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        new FindEmailsByUserRoleAndStatusQuery(
            status: $status,
            role: $invalidRoles
        );
    }

    #[Test]
    public function testGetStatus()
    {
        // Given
        $status = UserStatus::ACTIVE;
        $roles = [UserRole::ADMIN, UserRole::USER];
        $query = new FindEmailsByUserRoleAndStatusQuery(
            status: $status,
            role: $roles
        );

        // When
        $result = $query->getStatus();

        // Then
        $this->assertInstanceOf(UserStatus::class, $result);
        $this->assertEquals($status, $result);
    }

    #[Test]
    public function testGetRole()
    {
        // Given
        $status = UserStatus::ACTIVE;
        $roles = [UserRole::ADMIN, UserRole::USER];
        $query = new FindEmailsByUserRoleAndStatusQuery(
            status: $status,
            role: $roles
        );

        // When
        $result = $query->getRole();

        // Then
        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        foreach ($result as $role) {
            $this->assertNotNull(UserRole::tryFrom($role));
        }
    }
}
