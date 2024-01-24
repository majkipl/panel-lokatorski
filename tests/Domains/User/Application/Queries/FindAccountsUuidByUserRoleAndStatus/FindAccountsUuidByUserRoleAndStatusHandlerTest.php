<?php

namespace Tests\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus;

use App\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus\FindAccountsUuidByUserRoleAndStatusHandler;
use App\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus\FindAccountsUuidByUserRoleAndStatusQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindAccountsUuidByUserRoleAndStatusHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $accountRepositoryMock = $this->createMock(AccountRepositoryInterface::class);

        $status = UserStatus::ACTIVE->value;
        $roles = [UserRole::ADMIN->value, UserRole::USER->value];
        $expectedUuids = [fake()->uuid(), fake()->uuid(), fake()->uuid()];

        $collection = new Collection([]);
        foreach($expectedUuids as $expectedUuid) {
            $collection->add(['uuid' => $expectedUuid]);
        }

        $accountRepositoryMock->expects($this->once())
            ->method('getAccountByUserRoleAndStatus')
            ->with(
                $this->equalTo($status),
                $this->equalTo($roles),
            )
            ->willReturn($collection);

        $handler = new FindAccountsUuidByUserRoleAndStatusHandler($accountRepositoryMock);

        $query = new FindAccountsUuidByUserRoleAndStatusQuery($status, $roles);

        // Act
        $uuids = $handler->handle($query);

        // Assert
        $this->assertEquals($expectedUuids, $uuids);
    }
}
