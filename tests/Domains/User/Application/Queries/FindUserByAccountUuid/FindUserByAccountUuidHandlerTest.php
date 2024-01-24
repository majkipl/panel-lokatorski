<?php

namespace Tests\Domains\User\Application\Queries\FindUserByAccountUuid;

use App\Domains\User\Application\Queries\FindUserByAccountUuid\FindUserByAccountUuidHandler;
use App\Domains\User\Application\Queries\FindUserByAccountUuid\FindUserByAccountUuidQuery;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindUserByAccountUuidHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $uuid = fake()->uuid();
        $accountRepositoryMock = $this->createMock(AccountRepositoryInterface::class);
        $accountRepositoryMock->expects($this->once())
            ->method('getUserByAccountUuid')
            ->with(
                $this->equalTo($uuid)
            )
            ->willReturn(new User());

        $handler = new FindUserByAccountUuidHandler($accountRepositoryMock);
        $query = new FindUserByAccountUuidQuery($uuid);

        // Act & Assert
        $this->assertInstanceOf(User::class, $handler->handle($query));
    }
}
