<?php

namespace Tests\Domains\User\Application\Queries\FindUsersByStatusAndRole;

use App\Domains\User\Application\Queries\FindUsersByStatusAndRole\FindUsersByStatusAndRoleQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use Tests\TestCase;

class FindUsersByStatusAndRoleQueryTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstruction()
    {
        $roles = [UserRole::ADMIN->value, UserRole::USER->value];
        $status = UserStatus::ACTIVE->value;
        $query = new FindUsersByStatusAndRoleQuery($roles, $status);

        $this->assertInstanceOf(FindUsersByStatusAndRoleQuery::class, $query);
        $this->assertEquals($roles, $query->getRole());
        $this->assertEquals($status, $query->getStatus());
    }
}
