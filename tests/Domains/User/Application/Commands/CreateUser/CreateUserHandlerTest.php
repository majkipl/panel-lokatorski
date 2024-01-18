<?php

namespace Tests\Domains\User\Application\Commands\CreateUser;

use App\Domains\User\Application\Commands\CreateUser\CreateUserCommand;
use App\Domains\User\Application\Commands\CreateUser\CreateUserHandler;
use App\Domains\User\Application\DTO\UserDTO;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateUserHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        // Mock UserRepositoryInterface
        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);

        $email = fake()->safeEmail();
        $firstname = fake()->firstName();
        $lastname = fake()->lastName();
        $password = Str::password(10);
        $status = UserStatus::ACTIVE;
        $role = UserRole::USER;

        // Set up expectations
        $userRepositoryMock->expects($this->once())
            ->method('create')
            ->with(
                $this->callback(function (UserDTO $dto) use ($email, $firstname, $lastname, $password, $status, $role) {
                    // Check if DTO contains expected data
                    return $dto->email === $email &&
                        $dto->firstname === $firstname &&
                        $dto->lastname === $lastname &&
                        $dto->password === $password &&
                        $dto->status === $status &&
                        $dto->role === $role &&
                        true; // Return true if all checks pass
                })
            )
            ->willReturn(true); // Example return value

        // Create CreateUserHandler instance with mocked repository
        $handler = new CreateUserHandler($userRepositoryMock);

        // Create example DTO
        $userDTO = new UserDTO(
            email: $email,
            firstname: $firstname,
            lastname: $lastname,
            password: $password,
            status: $status,
            role: $role,
        );

        // Create example command
        $command = new CreateUserCommand($userDTO);

        // Call handle method and assert the return value
        $this->assertTrue($handler->handle($command));
    }
}
