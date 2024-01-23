<?php

namespace Tests\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus;

use App\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus\FindEmailsByUserRoleAndStatusHandler;
use App\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus\FindEmailsByUserRoleAndStatusQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindEmailsByUserRoleAndStatusHandlerTest extends TestCase
{
    use DatabaseTransactions;

    protected UserRepositoryInterface $userRepository;
    protected FindEmailsByUserRoleAndStatusHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        // Mocking UserRepositoryInterface
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
        // Mock data
        $emails = ['user1@example.com', 'user2@example.com'];
        $query = new FindEmailsByUserRoleAndStatusQuery(UserStatus::ACTIVE, [UserRole::ADMIN, UserRole::USER]);

        // Expectations
        $this->userRepository->shouldReceive('getUsersByStatusAndRole')->once()->andReturn(new Collection([
            ['email' => 'user1@example.com', 'status' => UserStatus::ACTIVE->value, 'role' => UserRole::ADMIN->value],
            ['email' => 'user2@example.com', 'status' => UserStatus::ACTIVE->value, 'role' => UserRole::USER->value],
        ]));

        // Execution
        $result = $this->handler->handle($query);

        // Assertions
        $this->assertEquals($emails, $result);
    }

    #[Test]
    public function testHandleReturnsEmptyArrayWhenNoUsersFound()
    {
        // Mock data
        $query = new FindEmailsByUserRoleAndStatusQuery(UserStatus::ACTIVE, [UserRole::ADMIN, UserRole::USER]);

        // Expectations
        $this->userRepository->shouldReceive('getUsersByStatusAndRole')->once()->andReturn(new Collection([]));

        // Execution
        $result = $this->handler->handle($query);

        // Assertions
        $this->assertEmpty($result);
    }
}
