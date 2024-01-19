<?php

namespace Tests\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus;

use App\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus\FindAccountsUuidByUserRoleAndStatusQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FindAccountsUuidByUserRoleAndStatusQueryTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstruction()
    {
        $status = UserStatus::ACTIVE->value;
        $roles = [UserRole::ADMIN->value, UserRole::USER->value];

        $query = new FindAccountsUuidByUserRoleAndStatusQuery($status, $roles);

        $this->assertEquals($status, $query->getStatus());
        $this->assertEquals($roles, $query->getRole());
    }
}
