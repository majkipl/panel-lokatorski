<?php

namespace Tests\Domains\User\Application\Queries\FindAccountUuidByUserId;

use App\Domains\User\Application\Queries\FindAccountUuidByUserId\FindAccountUuidByUserIdHandler;
use App\Domains\User\Application\Queries\FindAccountUuidByUserId\FindAccountUuidByUserIdQuery;
use App\Domains\User\Domain\Models\Account;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindAccountUuidByUserIdHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $userId= fake()->randomNumber();
        $accountUuid = fake()->uuid();

        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        $userRepositoryMock->expects($this->once())
            ->method('getAccountByUserId')
            ->with($userId)
            ->willReturn(new Account(['uuid' => $accountUuid]));

        $handler = new FindAccountUuidByUserIdHandler($userRepositoryMock);

        $query = new FindAccountUuidByUserIdQuery($userId);

        // Act
        $result = $handler->handle($query);

        // Assert
        $this->assertEquals($accountUuid, $result);
    }
}
