<?php

namespace Tests\Domains\User\Application\Queries\FindAccountUuidByUserId;

use App\Domains\User\Application\Queries\FindAccountUuidByUserId\FindAccountUuidByUserIdHandler;
use App\Domains\User\Application\Queries\FindAccountUuidByUserId\FindAccountUuidByUserIdQuery;
use App\Domains\User\Domain\Models\Account;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FindAccountUuidByUserIdHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        $userId= fake()->randomNumber();
        $accountUuid = fake()->uuid();

        // Create UserRepositoryInterface mock
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        // Set up expectation for getAccountByUserId method in UserRepositoryInterface
        $userRepositoryMock->expects($this->once())
            ->method('getAccountByUserId')
            ->with($userId)
            ->willReturn(new Account(['uuid' => $accountUuid]));

        // Create FindAccountUuidByUserIdHandler instance with mocked UserRepositoryInterface
        $handler = new FindAccountUuidByUserIdHandler($userRepositoryMock);

        // Create FindAccountUuidByUserIdQuery instance
        $query = new FindAccountUuidByUserIdQuery($userId);

        // Call handle method
        $result = $handler->handle($query);

        // Check if the result matches the expected account UUID
        $this->assertEquals($accountUuid, $result);
    }
}
