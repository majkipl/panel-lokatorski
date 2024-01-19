<?php

namespace Tests\Domains\Expense\Application\Projectors;

use App\Domains\Expense\Application\Projectors\ExpenseProjector;
use App\Domains\Expense\Application\Queries\FindAllByAccountUuid\FindAllByAccountUuidQuery;
use App\Domains\Expense\Domain\Events\ExpenseAdded;
use App\Domains\Expense\Domain\Events\ExpenseCanceled;
use App\Domains\User\Application\Projectors\AccountBalanceProjector;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Domains\User\Domain\Models\User;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExpenseProjectorTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = app(CommandBus::class);
        $this->queryBus = app(QueryBus::class);

        // Create PaymentProjector instance with mocked command bus and query bus
        $this->projector = new ExpenseProjector($this->commandBus, $this->queryBus);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testOnAccountCreated()
    {
        // Turn off observer
        User::unsetEventDispatcher();

        // Get instance model
        $user = User::factory()->create();

        // Turn on observer
        User::setEventDispatcher(new Dispatcher());

        // Arrange
        $projector = new AccountBalanceProjector();
        $event = new AccountCreated(['user_id' => $user->id]);
        $projector->onAccountCreated($event);

        $this->projector->onAccountCreated(new AccountCreated([
            'uuid' => $user->refresh()->account->uuid,
        ]));

        $this->assertDatabaseHas('expenses', ['account_uuid' => $user->refresh()->account->uuid]);

    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testOnExpenseAdded()
    {
        // Get instance model
        $user = User::factory()->create([
            'role' => UserRole::USER->value,
            'status' => UserStatus::ACTIVE->value
        ]);

        $part1 = User::factory()->create([
            'role' => UserRole::USER->value,
            'status' => UserStatus::ACTIVE->value
        ]);
        $part2 = User::factory()->create([
            'role' => UserRole::USER->value,
            'status' => UserStatus::ACTIVE->value
        ]);

        $event = new ExpenseAdded(
            accountUuid: $user->account->uuid,
            name: 'name',
            amount: 100,
            participants: [
                $part1->account->uuid,
                $part2->account->uuid,
            ]
        );

        event($event);

        $this->projector->onExpenseAdded(
            event: $event
        );

        $this->assertDatabaseHas('expenses', ['account_uuid' => $user->refresh()->account->uuid]);

        //todo: assert data or count(expenses)
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testOnExpenseCanceled()
    {
        // Get instance model
        $user = User::factory()->create([
            'role' => UserRole::USER->value,
            'status' => UserStatus::ACTIVE->value
        ]);

        $part1 = User::factory()->create([
            'role' => UserRole::USER->value,
            'status' => UserStatus::ACTIVE->value
        ]);
        $part2 = User::factory()->create([
            'role' => UserRole::USER->value,
            'status' => UserStatus::ACTIVE->value
        ]);


        $event = new ExpenseCanceled(
            accountUuid: $user->account->uuid,
            name: 'name',
            amount: 100,
            eventId: 1,
            participants: [
                $part1->account->uuid,
                $part2->account->uuid,
            ]
        );

        event($event);

        $this->projector->onExpenseCanceled(
            event: $event
        );

        $this->assertDatabaseHas('expenses', ['account_uuid' => $user->refresh()->account->uuid]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testGetAll()
    {
        // Get instance model
        $users = User::factory(3)->create();

        foreach ($users as $user) {
            $event = new ExpenseAdded(
                accountUuid: $user->account->uuid,
                name: 'name',
                amount: 100,
                participants: [
                    $users[0]->account->uuid,
                    $users[1]->account->uuid,
                    $users[2]->account->uuid,
                ]
            );

            event($event);

            $this->projector->onExpenseAdded(
                event: $event
            );
        }

        foreach ($users as $user) {
            $expense = $user->refresh()->account->expenses()->latest()->first();
            $this->assertEquals($expense->account_uuid, $user->account->uuid);
            $this->assertDatabaseHas('expenses', ['account_uuid' => $user->refresh()->account->uuid]);
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testGetExpensesForNow()
    {
        $user = User::factory()->create();
        $count_expenses = fake()->numberBetween(3,5);

        for ($i= 0; $i < $count_expenses; $i++) {
            $event = new ExpenseAdded(
                accountUuid: $user->account->uuid,
                name: 'name',
                amount: 100,
                participants: [
                    $user->account->uuid
                ]
            );

            event($event);

            $this->projector->onExpenseAdded(
                event: $event
            );
        }

        $data = $this->projector->getExpensesForNow($user->account->uuid);

        $this->assertEquals($count_expenses, count($data)/2);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testGetTodaysExpenses()
    {
        $user = User::factory()->create();
        $count_expenses = fake()->numberBetween(3,5);

        for ($i= 0; $i < $count_expenses; $i++) {
            $event = new ExpenseAdded(
                accountUuid: $user->account->uuid,
                name: 'name',
                amount: 100,
                participants: [
                    $user->account->uuid
                ]
            );

            event($event);

            $this->projector->onExpenseAdded(
                event: $event
            );
        }

        $data = $this->projector->getTodaysExpenses($user->account->uuid);

        $this->assertEquals($count_expenses, count($data)/2);
    }

}
