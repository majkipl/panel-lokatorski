<?php

namespace Tests\Domains\User\Application\Queries\FindUserByAccountUuid;

use App\Domains\User\Application\Queries\FindUserByAccountUuid\FindUserByAccountUuidHandler;
use App\Domains\User\Application\Queries\FindUserByAccountUuid\FindUserByAccountUuidQuery;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use Tests\TestCase;

class FindUserByAccountUuidHandlerTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        // Mock AccountRepositoryInterface
        $accountRepositoryMock = $this->createMock(AccountRepositoryInterface::class);

        $uuid = fake()->uuid();

        // Set up expectations
        $accountRepositoryMock->expects($this->once())
            ->method('getUserByAccountUuid')
            ->with(
                $this->equalTo($uuid) // Example UUID
            )
            ->willReturn(new User()); // Example return value

        // Create FindUserByAccountUuidHandler instance with mocked repository
        $handler = new FindUserByAccountUuidHandler($accountRepositoryMock);

        // Create example query
        $query = new FindUserByAccountUuidQuery($uuid);

        // Call handle method and assert the return value
        $this->assertInstanceOf(User::class, $handler->handle($query));
    }
}
