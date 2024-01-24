<?php

namespace Tests\Domains\Balance\Application\Projectors;

use App\Domains\Balance\Application\Commands\Save\SaveCommand;
use App\Domains\Balance\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Balance\Application\Projectors\BalanceProjector;
use App\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid\FindLatestBalanceByAccountUuidQuery;
use App\Domains\Expense\Domain\Events\ExpenseAdded;
use App\Domains\Expense\Domain\Events\ExpenseCanceled;
use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Domains\User\Domain\Models\User;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BalanceProjectorTest extends TestCase
{
    #[Test]
    public function testOnAccountCreated()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BalanceProjector($commandBus, $queryBus);
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
        $queryBus->expects($this->once())->method('ask')->willReturn(new User(['created-at' => Carbon::now()->toDateTimeString()]));
        $commandBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(SaveCommand::class));
        $projector->onAccountCreated($event);
    }

    #[Test]
    public function testOnMoneyAdded()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BalanceProjector($commandBus, $queryBus);
        $metaData = ['created-at' => Carbon::now()->toDateTimeString()];
        Event::fake();
        $eventAccountUuid = fake()->uuid();
        $eventAmount = fake()->randomFloat(2);
        $event = new MoneyAdded(
            accountUuid: $eventAccountUuid,
            amount: $eventAmount,
        );
        $event->setMetaData($metaData);

        // Act
        event($event);

        // Assert
        Event::assertDispatched(MoneyAdded::class, function ($event) use ($eventAccountUuid, $eventAmount) {
            return $event->accountUuid === $eventAccountUuid && $event->amount === $eventAmount;
        });
        $queryBus->expects($this->once())->method('ask')->willReturn(serialize([]));
        $commandBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));
        $projector->onMoneyAdded($event);
    }

    #[Test]
    public function testOnMoneySubtracted()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BalanceProjector($commandBus, $queryBus);
        $metaData = ['created-at' => Carbon::now()->toDateTimeString()];
        Event::fake();
        $eventAccountUuid = fake()->uuid();
        $eventAmount = fake()->randomFloat(2);
        $event = new MoneySubtracted(
            accountUuid: $eventAccountUuid,
            amount: $eventAmount,
        );
        $event->setMetaData($metaData);

        // Act
        event($event);

        // Assert
        Event::assertDispatched(MoneySubtracted::class, function ($event) use ($eventAccountUuid, $eventAmount) {
            return $event->accountUuid === $eventAccountUuid && $event->amount === $eventAmount;
        });
        $queryBus->expects($this->once())->method('ask')->willReturn(serialize([]));
        $commandBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));
        $projector->onMoneySubtracted($event);
    }

    #[Test]
    public function testOnExpenseAdded()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BalanceProjector($commandBus, $queryBus);
        $metaData = ['created-at' => Carbon::now()->toDateTimeString()];
        Event::fake();
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

        // Assert
        Event::assertDispatched(ExpenseAdded::class, function ($event) use ($eventAccountUuid, $eventName, $eventAmount) {
            return $event->accountUuid === $eventAccountUuid && $event->name === $eventName && $event->amount === $eventAmount;
        });
        $queryBus->expects($this->atLeastOnce())->method('ask')->willReturn(serialize([]));
        $commandBus->expects($this->atLeastOnce())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));
        $projector->onExpenseAdded($event);
    }

    #[Test]
    public function testOnExpenseCanceled()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BalanceProjector($commandBus, $queryBus);
        $metaData = ['created-at' => Carbon::now()->toDateTimeString()];
        Event::fake();
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

        // Act
        event($event);

        // Assert
        Event::assertDispatched(ExpenseCanceled::class, function ($event) use ($eventAccountUuid, $eventName, $eventAmount, $eventId) {
            return $event->accountUuid === $eventAccountUuid && $event->name === $eventName && $event->amount === $eventAmount && $event->eventId === $eventId;
        });
        $queryBus->expects($this->atLeastOnce())->method('ask')->willReturn(serialize([]));
        $commandBus->expects($this->atLeastOnce())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));
        $projector->onExpenseCanceled($event);
    }

    #[Test]
    public function testGetBalance()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = serialize([time() => 100]); // Example projection data
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $queryBus->expects($this->once())
            ->method('ask')
            ->with(new FindLatestBalanceByAccountUuidQuery(uuid: $uuid))
            ->willReturn($projection);
        $projector = new BalanceProjector(
            commandBus: $commandBus,
            queryBus: $queryBus
        );

        // Act
        $result = $projector->getBalance($uuid);

        // Assert
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals(unserialize($projection), $result);
    }
}
