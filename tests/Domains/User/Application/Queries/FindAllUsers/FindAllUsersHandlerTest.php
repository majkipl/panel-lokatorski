<?php

namespace Tests\Domains\User\Application\Queries\FindAllUsers;

use App\Domains\User\Application\Queries\FindAllUsers\FindAllUsersHandler;
use App\Domains\User\Application\Queries\FindAllUsers\FindAllUsersQuery;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindAllUsersHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        $userRepositoryMock->expects($this->once())
            ->method('getAllUsers')
            ->willReturn(new Collection());

        $handler = new FindAllUsersHandler($userRepositoryMock);

        $query = new FindAllUsersQuery();

        // Act & Assert
        $this->assertInstanceOf(Collection::class, $handler->handle($query));
    }
}
