<?php

namespace Tests\Domains\User\Application\Queries\FindAllUsers;

use App\Domains\User\Application\Queries\FindAllUsers\FindAllUsersHandler;
use App\Domains\User\Application\Queries\FindAllUsers\FindAllUsersQuery;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class FindAllUsersHandlerTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        // Mock UserRepositoryInterface
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        // Set up expectations
        $userRepositoryMock->expects($this->once())
            ->method('getAllUsers')
            ->willReturn(new Collection()); // Example return value

        // Create FindAllUsersHandler instance with mocked repository
        $handler = new FindAllUsersHandler($userRepositoryMock);

        // Create example query
        $query = new FindAllUsersQuery();

        // Call handle method and assert the return value
        $this->assertInstanceOf(Collection::class, $handler->handle($query));
    }
}
