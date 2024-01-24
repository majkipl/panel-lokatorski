<?php

namespace Tests\Domains\User\Application\Commands\CreateUser;

use App\Domains\User\Application\Commands\CreateUser\CreateUserCommand;
use App\Domains\User\Application\DTO\UserDTO;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CreateUserCommandTest extends TestCase
{
    #[Test]
    public function testConstruction()
    {
        // Arrange
        $email = fake()->safeEmail();
        $firstname = fake()->firstName();
        $lastname = fake()->lastName();
        $password = Str::password(10);
        $status = UserStatus::ACTIVE;
        $role = UserRole::USER;
        $email_verified_at = now();
        $remember_token = 'random_token';
        $created_at = now();
        $updated_at = now();
        $last_login_at = now();

        $userDTO = new UserDTO(
            email: $email,
            firstname: $firstname,
            lastname: $lastname,
            password: $password,
            status: $status,
            role: $role,
            email_verified_at: $email_verified_at,
            remember_token: $remember_token,
            created_at: $created_at,
            updated_at: $updated_at,
            last_login_at: $last_login_at
        );

        // Act
        $command = new CreateUserCommand($userDTO);

        // Assert
        $this->assertInstanceOf(CreateUserCommand::class, $command);
        $this->assertInstanceOf(UserDTO::class, $command->getDto());
        $this->assertEquals($email, $command->getDto()->email);
        $this->assertEquals($firstname, $command->getDto()->firstname);
        $this->assertEquals($lastname, $command->getDto()->lastname);
        $this->assertEquals($password, $command->getDto()->password);
        $this->assertEquals($status, $command->getDto()->status);
        $this->assertEquals($role, $command->getDto()->role);
        $this->assertEquals($email_verified_at, $command->getDto()->email_verified_at);
        $this->assertEquals($remember_token, $command->getDto()->remember_token);
        $this->assertEquals($created_at, $command->getDto()->created_at->format('Y-m-d H:i:s'));
        $this->assertEquals($updated_at, $command->getDto()->updated_at);
        $this->assertEquals($last_login_at, $command->getDto()->last_login_at);
    }
}
