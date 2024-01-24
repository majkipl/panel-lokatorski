<?php

namespace Tests\Domains\User\Application\Queries\FindUsersByStatusAndRole;

use App\Domains\User\Application\Queries\FindUsersByStatusAndRole\FindUsersByStatusAndRoleHandler;
use App\Domains\User\Application\Queries\FindUsersByStatusAndRole\FindUsersByStatusAndRoleQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindUsersByStatusAndRoleHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $roles = [UserRole::ADMIN->value, UserRole::USER->value];
        $status = UserStatus::ACTIVE->value;

        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $userRepositoryMock->expects($this->once())
            ->method('getUsersByStatusAndRole')
            ->with(
                $this->equalTo($roles),
                $this->equalTo($status)
            )
            ->willReturn(new Collection());

        $handler = new FindUsersByStatusAndRoleHandler($userRepositoryMock);
        $query = new FindUsersByStatusAndRoleQuery($roles, $status);

        // Act & Assert
        $this->assertInstanceOf(Collection::class, $handler->handle($query));
    }
}
