<?php

namespace Tests\Domains\Expense\Infrastructure\Repositories;

use App\Domains\Expense\Domain\Models\Expense;
use App\Domains\Expense\Infrastructure\Repositories\ExpenseRepository;
use App\Domains\User\Application\Commands\AddExpenseByUserId\AddExpenseByUserIdCommand;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Models\User;
use App\Interfaces\Command\CommandBus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExpenseRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testGetLatestByAccountUuid()
    {
        $user = User::factory()->create([
            'role' => UserRole::USER->value,
            'status' => UserStatus::ACTIVE->value
        ]);
        $amount = 100;
        $name = fake()->word();

        $commandBus = app(CommandBus::class);
        $commandBus->dispatch(
            command: new AddExpenseByUserIdCommand(
                id: $user->id,
                name: $name,
                amount: $amount
            )
        );

        // Create ExpenseRepository instance
        $repository = new ExpenseRepository(new Expense());

        // Retrieve the latest expense by account UUID
        $latestExpense = $repository->getLatestByAccountUuid($user->account->uuid);

        $expenses = unserialize($latestExpense->projection);
        $expense = reset($expenses);

        $this->assertCount(1, $expenses);
        $this->assertEquals($amount, $expense['amount']);
        $this->assertEquals($user->account->uuid, $expense['accountUuid']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testUpdateProjection()
    {
        $user = User::factory()->create([
            'role' => UserRole::USER->value,
            'status' => UserStatus::ACTIVE->value
        ]);

        // Create ExpenseRepository instance
        $repository = new ExpenseRepository(new Expense());

        $updated = $repository->updateProjection($user->account->uuid, 'new_projection');

        // Assert that the update operation was successful
        $this->assertTrue($updated);

        // Retrieve the expense after update
        $updatedExpense = Expense::where('account_uuid', $user->account->uuid)->latest()->first();

        // Assert that the projection of the updated expense matches the new projection value
        $this->assertEquals('new_projection', $updatedExpense->projection);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testSave()
    {
        $user = User::factory()->create([
            'role' => UserRole::USER->value,
            'status' => UserStatus::ACTIVE->value
        ]);

        // Create ExpenseRepository instance
        $repository = new ExpenseRepository($user->account->expenses()->latest()->first());

        // Save a new expense
        $saved = $repository->save($user->account->uuid, 'test_projection');

        // Assert that the save operation was successful
        $this->assertTrue($saved);

        // Retrieve the saved expense
        $savedExpense = Expense::where('account_uuid', $user->account->uuid)->latest()->first();

        // Assert that the retrieved expense is not null
        $this->assertNotNull($savedExpense);

        // Assert that the projection of the saved expense matches the provided projection value
        $this->assertEquals('test_projection', $savedExpense->projection);
    }
}
