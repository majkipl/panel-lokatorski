<?php

namespace Tests\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus;

use App\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus\FindEmailsByUserRoleAndStatusHandler;
use App\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus\FindEmailsByUserRoleAndStatusQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindEmailsByUserRoleAndStatusHandlerTest extends TestCase
{
    protected UserRepositoryInterface $userRepository;
    protected FindEmailsByUserRoleAndStatusHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->handler = new FindEmailsByUserRoleAndStatusHandler($this->userRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function testHandleReturnsArrayOfEmails()
    {
        // Arrange
        $emails = [fake()->safeEmail(), fake()->safeEmail()];
        $query = new FindEmailsByUserRoleAndStatusQuery(UserStatus::ACTIVE, [UserRole::ADMIN, UserRole::USER]);

        $this->userRepository->shouldReceive('getUsersByStatusAndRole')->once()->andReturn(new Collection([
            ['email' => $emails[0], 'status' => UserStatus::ACTIVE->value, 'role' => UserRole::ADMIN->value],
            ['email' => $emails[1], 'status' => UserStatus::ACTIVE->value, 'role' => UserRole::USER->value],
        ]));

        // Act
        $result = $this->handler->handle($query);

        // Assert
        $this->assertEquals($emails, $result);
    }

    #[Test]
    public function testHandleReturnsEmptyArrayWhenNoUsersFound()
    {
        // Arrange
        $query = new FindEmailsByUserRoleAndStatusQuery(UserStatus::ACTIVE, [UserRole::ADMIN, UserRole::USER]);
        $this->userRepository->shouldReceive('getUsersByStatusAndRole')->once()->andReturn(new Collection([]));

        // Act
        $result = $this->handler->handle($query);

        // Assert
        $this->assertEmpty($result);
    }
}
