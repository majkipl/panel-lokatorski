<?php

namespace Tests\Domains\User\Application\Commands\CreateUser;

use App\Domains\User\Application\Commands\CreateUser\CreateUserCommand;
use App\Domains\User\Application\Commands\CreateUser\CreateUserHandler;
use App\Domains\User\Application\DTO\UserDTO;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateUserHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $email = fake()->safeEmail();
        $firstname = fake()->firstName();
        $lastname = fake()->lastName();
        $password = Str::password(10);
        $status = UserStatus::ACTIVE;
        $role = UserRole::USER;

        $userRepositoryMock = $this->createMock(UserRepositoryInterface::class);
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
            ->willReturn(true);

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

        $command = new CreateUserCommand($userDTO);

        // Act & Assert
        $this->assertTrue($handler->handle($command));
    }
}
