<?php

namespace Tests\Domains\Expense\Application\Projectors;

use App\Domains\Expense\Application\Commands\Save\SaveCommand;
use App\Domains\Expense\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Expense\Application\Projectors\ExpenseProjector;
use App\Domains\Expense\Application\Queries\FindAllByAccountUuid\FindAllByAccountUuidQuery;
use App\Domains\Expense\Domain\Events\ExpenseAdded;
use App\Domains\Expense\Domain\Events\ExpenseCanceled;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExpenseProjectorTest extends TestCase
{
    public function testOnAccountCreated()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new ExpenseProjector($commandBus, $queryBus);
        Event::fake();
        $accountAttributes = ['uuid' => fake()->uuid()];
        $metaData = ['created-at' => Carbon::now()->toDateTimeString()];
        $event = new AccountCreated($accountAttributes);
        $event->setMetaData($metaData);

        // Act
        event($event);

        // Assert
        Event::assertDispatched(AccountCreated::class, function ($event) use ($accountAttributes) {
            return $event->accountAttributes['uuid'] === $accountAttributes['uuid'];
        });
        $commandBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(SaveCommand::class));
        $projector->onAccountCreated($event);
    }

    #[Test]
    public function testOnExpenseAdded()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new ExpenseProjector($commandBus, $queryBus);
        Event::fake();
        $metaData = ['created-at' => Carbon::now()->toDateTimeString(), 'stored-event-id' => fake()->randomNumber()];
        $eventAccountUuid = fake()->uuid();
        $eventName = fake()->word();
        $eventAmount = fake()->randomFloat(2);
        $eventParticipants = [fake()->uuid(), fake()->uuid()];
        $event = new ExpenseAdded(
            accountUuid: $eventAccountUuid,
            name: $eventName,
            amount: $eventAmount,
            participants: $eventParticipants
        );
        $event->setMetaData($metaData);

        // Act
        event($event);
        $queryBus->expects($this->atLeastOnce())->method('ask')->willReturn(serialize([]));
        $commandBus->expects($this->atLeastOnce())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));
        $projector->onExpenseAdded($event);

        // Assert
        Event::assertDispatched(ExpenseAdded::class, function ($event) use ($eventAccountUuid, $eventName, $eventAmount) {
            return $event->accountUuid === $eventAccountUuid && $event->name === $eventName && $event->amount === $eventAmount;
        });
    }

    #[Test]
    public function testOnExpenseCanceled()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new ExpenseProjector($commandBus, $queryBus);
        Event::fake();
        $metaData = ['created-at' => Carbon::now()->toDateTimeString()];
        $eventAccountUuid = fake()->uuid();
        $eventName = fake()->word();
        $eventAmount = fake()->randomFloat(2);
        $eventParticipants = [fake()->uuid(), fake()->uuid()];
        $eventId = fake()->randomNumber();
        $event = new ExpenseCanceled(
            accountUuid: $eventAccountUuid,
            name: $eventName,
            amount: $eventAmount,
            eventId: $eventId,
            participants: $eventParticipants
        );
        $event->setMetaData($metaData);
        event($event);

        // Act
        $queryBus->expects($this->atLeastOnce())->method('ask')->willReturn(serialize([]));
        $commandBus->expects($this->atLeastOnce())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));
        $projector->onExpenseCanceled($event);

        // Assert
        Event::assertDispatched(ExpenseCanceled::class, function ($event) use ($eventAccountUuid, $eventName, $eventAmount) {
            return $event->accountUuid === $eventAccountUuid && $event->name === $eventName && $event->amount === $eventAmount;
        });
    }

    #[Test]
    public function testGetAll()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new ExpenseProjector($commandBus, $queryBus);
        $uuid = fake()->uuid();

        // Act
        $queryBus->expects($this->once())
            ->method('ask')
            ->with($this->isInstanceOf(FindAllByAccountUuidQuery::class))
            ->willReturn([]);
        $result = $projector->getAll($uuid);

        // Assert
        $this->assertIsArray($result);
    }

    #[Test]
    public function testGetExpensesForNow()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new ExpenseProjector($commandBus, $queryBus);
        $uuid = fake()->uuid();
        $expenses = [
            ['created_year' => Carbon::now()->year, 'created_month' => Carbon::now()->locale('pl')->isoFormat('MMMM')],
            ['created_year' => Carbon::now()->subYear()->year, 'created_month' => Carbon::now()->subYear()->locale('pl')->isoFormat('MMMM')],
        ];
        $queryBus->expects($this->once())
            ->method('ask')
            ->with($this->isInstanceOf(FindAllByAccountUuidQuery::class))
            ->willReturn($expenses);

        // Act
        $result = $projector->getExpensesForNow($uuid);

        // Assert
        $this->assertIsArray($result);
        foreach ($result as $expense) {
            $this->assertEquals(Carbon::now()->year, $expense['created_year']);
            $this->assertEquals(Carbon::now()->locale('pl')->isoFormat('MMMM'), $expense['created_month']);
        }
    }

    #[Test]
    public function testGetTodaysExpenses()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new ExpenseProjector($commandBus, $queryBus);
        $uuid = fake()->uuid();
        $expenses = [
            [
                'created_at' => Carbon::now(),
            ],
            [
                'created_at' => Carbon::now()->subDay(),
            ],
        ];

        // Act
        $queryBus->expects($this->once())
            ->method('ask')
            ->with($this->isInstanceOf(FindAllByAccountUuidQuery::class))
            ->willReturn($expenses);
        $result = $projector->getTodaysExpenses($uuid);

        // Assert
        $this->assertIsArray($result);
        foreach ($result as $expense) {
            $this->assertEquals(Carbon::now()->year, $expense['created_at']->year);
            $this->assertEquals(Carbon::now()->month, $expense['created_at']->month);
            $this->assertEquals(Carbon::now()->day, $expense['created_at']->day);
        }
    }
}
