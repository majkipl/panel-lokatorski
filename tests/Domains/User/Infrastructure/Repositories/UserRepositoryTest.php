<?php

namespace Tests\Domains\User\Infrastructure\Repositories;

use App\Domains\User\Application\DTO\UserDTO;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Models\User;
use App\Domains\User\Infrastructure\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_get_all_users()
    {
        // Create some users
        User::factory()->count(3)->create();

        // Create repository instance
        $repository = new UserRepository(new User());

        // Get all users
        $users = $repository->getAllUsers();

        // Assert that the number of retrieved users matches the number created
        $this->assertCount(3, $users);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_get_users_by_status_and_role()
    {
        // Create some users with specific roles and statuses
        $user1 = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $user2 = User::factory()->create(['role' => 'user', 'status' => 'active']);
        $user3 = User::factory()->create(['role' => 'admin', 'status' => 'inactive']);

        // Create repository instance
        $repository = new UserRepository(new User());

        // Get users with specific role and status
        $users = $repository->getUsersByStatusAndRole(['admin'], 'active');

        // Assert that the correct users are retrieved
        $this->assertCount(1, $users);
        $this->assertEquals($user1->id, $users->first()->id);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_update_user_status()
    {
        // Create a user
        $user = User::factory()->create();

        // Create repository instance
        $repository = new UserRepository(new User());

        // New status
        $newStatus = 'inactive';

        // Update user status
        $updated = $repository->updateStatus($user->id, $newStatus);

        // Assert that the update was successful
        $this->assertTrue($updated);

        // Retrieve the user from the database
        $updatedUser = User::find($user->id);

        // Assert that the user's status has been updated
        $this->assertEquals($newStatus, $updatedUser->status);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_get_account_by_user_id()
    {
        // Create a user with an associated account
        $user = User::factory()->create();

        // Create repository instance
        $repository = new UserRepository(new User());

        // Get user's account
        $retrievedAccount = $repository->getAccountByUserId($user->id);

        // Assert that the retrieved account belongs to the correct user
        $this->assertEquals($user->account->id, $retrievedAccount->id);
        $this->assertEquals($user->account->user_id, $user->id);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_add_money_to_user_account()
    {
        // Create a user with an associated account
        $user = User::factory()->create();

        // Initial balance
        $initialBalance = $user->account->balance;

        // Amount to add
        $amountToAdd = 100.50;

        // Create repository instance
        $repository = new UserRepository(new User());

        // Add money to user's account
        $repository->addMoney($user->id, $amountToAdd);

        // Assert that the balance has been updated correctly
        $this->assertEquals($initialBalance + $amountToAdd, $user->account->refresh()->balance);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_subtract_money_from_user_account()
    {
        // Create a user with an associated account
        $user = User::factory()->create();

        // Initial balance
        $initialBalance = $user->account->balance;

        // Amount to subtract (ensure it's less than the initial balance)
        $amountToSubtract = 50.25;

        // Create repository instance
        $repository = new UserRepository(new User());

        // Subtract money from user's account
        $repository->subtractMoney($user->id, $amountToSubtract);

        // Assert that the balance has been updated correctly
        $this->assertEquals($initialBalance - $amountToSubtract, $user->account->refresh()->balance);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_create_new_user()
    {
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

        // Create UserDTO object with dummy data
        $userDTO = new UserDTO(
            email: $email,
            firstname: $firstname,
            lastname: $lastname,
            password: bcrypt($password),
            status: $status,
            role: $role,
            email_verified_at: $email_verified_at,
            remember_token: $remember_token,
            created_at: $created_at,
            updated_at: $updated_at,
            last_login_at: $last_login_at
        );

        // Create repository instance
        $repository = new UserRepository(new User());

        // Call the create method
        $created = $repository->create($userDTO);

        // Assert that the user was created successfully
        $this->assertTrue($created);

        // Retrieve the created user from the database
        $createdUser = User::where('email', $email)->first();

        // Assert that the user exists in the database
        $this->assertNotNull($createdUser);

        // Assert that the user's attributes match the DTO data
        $this->assertEquals($email, $createdUser->email);
        $this->assertEquals($firstname, $createdUser->firstname);
        $this->assertEquals($lastname, $createdUser->lastname);
        $this->assertTrue(password_verify($password, $createdUser->password));
        $this->assertEquals($status->value, $createdUser->status);
        $this->assertEquals($role->value, $createdUser->role);
        $this->assertNotNull($createdUser->email_verified_at);
        $this->assertEquals($remember_token, $createdUser->remember_token);
        $this->assertEquals($created_at->format('Y-m-d H:i:s'), $createdUser->created_at->format('Y-m-d H:i:s'));
        $this->assertEquals($updated_at->format('Y-m-d H:i:s'), $createdUser->updated_at->format('Y-m-d H:i:s'));
        $this->assertEquals($last_login_at->format('Y-m-d H:i:s'), $createdUser->last_login_at);
    }
}
