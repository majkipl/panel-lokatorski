<?php

namespace Tests\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus;

use App\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus\FindAccountsUuidByUserRoleAndStatusHandler;
use App\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus\FindAccountsUuidByUserRoleAndStatusQuery;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FindAccountsUuidByUserRoleAndStatusHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        // Mock AccountRepositoryInterface
        $accountRepositoryMock = $this->createMock(AccountRepositoryInterface::class);

        $status = 'active';
        $roles = ['admin', 'user'];
        $expectedUuids = ['uuid1', 'uuid2', 'uuid3'];

        // Set up expectation for getAccountByUserRoleAndStatus method in AccountRepositoryInterface
        $accountRepositoryMock->expects($this->once())
            ->method('getAccountByUserRoleAndStatus')
            ->with(
                $this->equalTo($status), // Status
                $this->equalTo($roles) // Role
            )
            ->willReturn(new Collection([
                ['uuid' => 'uuid1'],
                ['uuid' => 'uuid2'],
                ['uuid' => 'uuid3'],
            ]));

        // Create FindAccountsUuidByUserRoleAndStatusHandler instance with mocked AccountRepositoryInterface
        $handler = new FindAccountsUuidByUserRoleAndStatusHandler($accountRepositoryMock);

        // Create FindAccountsUuidByUserRoleAndStatusQuery instance
        $query = new FindAccountsUuidByUserRoleAndStatusQuery($status, $roles);

        // Call handle method
        $uuids = $handler->handle($query);

        // Check if returned uuids match the expected uuids
        $this->assertEquals($expectedUuids, $uuids);
    }
}
