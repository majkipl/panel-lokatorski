<?php

namespace Tests\Domains\User\Application\Queries\FindUsersByStatusAndRole;

use App\Domains\User\Application\Queries\FindUsersByStatusAndRole\FindUsersByStatusAndRoleHandler;
use App\Domains\User\Application\Queries\FindUsersByStatusAndRole\FindUsersByStatusAndRoleQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FindUsersByStatusAndRoleHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        // Mock UserRepositoryInterface
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
        $roles = [UserRole::ADMIN->value, UserRole::USER->value];
        $status = UserStatus::ACTIVE->value;

        // Set up expectations
        $userRepositoryMock->expects($this->once())
            ->method('getUsersByStatusAndRole')
            ->with(
                $this->equalTo($roles),  // Example roles
                $this->equalTo($status)              // Example status
            )
            ->willReturn(new Collection()); // Example return value

        // Create FindUsersByStatusAndRoleHandler instance with mocked repository
        $handler = new FindUsersByStatusAndRoleHandler($userRepositoryMock);

        // Create example query
        $query = new FindUsersByStatusAndRoleQuery($roles, $status);

        // Call handle method and assert the return value
        $this->assertInstanceOf(Collection::class, $handler->handle($query));
    }
}
