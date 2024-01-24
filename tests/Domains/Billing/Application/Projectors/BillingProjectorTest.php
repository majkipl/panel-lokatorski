<?php

namespace Tests\Domains\Billing\Application\Projectors;

use App\Domains\Billing\Application\Classes\BillingData;
use App\Domains\Billing\Application\Classes\MonthlyData;
use App\Domains\Billing\Application\Commands\Save\SaveCommand;
use App\Domains\Billing\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Billing\Application\Projectors\BillingProjector;
use App\Domains\Expense\Domain\Events\ExpenseAdded;
use App\Domains\Expense\Domain\Events\ExpenseCanceled;
use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BillingProjectorTest extends TestCase
{
    #[Test]
    public function testOnAccountCreated()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BillingProjector($commandBus, $queryBus);

        // Expect dispatching SaveCommand
        $commandBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(SaveCommand::class));

        // Act
        $projector->onAccountCreated(new AccountCreated(['uuid' => fake()->uuid()]));

        // Assert
        // No additional assertions needed
    }

    #[Test]
    public function testOnMoneyAdded()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BillingProjector($commandBus, $queryBus);

        // Prepare event data
        $metaData = ['created-at' => Carbon::now()->toDateTimeString()];
        $eventAccountUuid = fake()->uuid();
        $eventAmount = fake()->randomFloat(2);
        $event = new MoneyAdded(accountUuid: $eventAccountUuid, amount: $eventAmount);
        $event->setMetaData($metaData);
        Event::fake();

        // Act
        event($event);
        $queryBus->expects($this->once())->method('ask')->willReturn(serialize(new BillingData()));
        $commandBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));
        $projector->onMoneyAdded($event);

        // Assert
        Event::assertDispatched(MoneyAdded::class, function ($event) use ($eventAccountUuid, $eventAmount) {
            return $event->accountUuid === $eventAccountUuid && $event->amount === $eventAmount;
        });
    }

    #[Test]
    public function testOnMoneySubtracted()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BillingProjector($commandBus, $queryBus);
        Event::fake();
        $metaData = ['created-at' => Carbon::now()->toDateTimeString()];
        $eventAccountUuid = fake()->uuid();
        $eventAmount = fake()->randomFloat(2);
        $event = new MoneySubtracted(accountUuid: $eventAccountUuid, amount: $eventAmount);
        $event->setMetaData($metaData);
        event($event);

        // Act
        $queryBus->expects($this->once())->method('ask')->willReturn(serialize(new BillingData()));
        $commandBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));
        $projector->onMoneySubtracted($event);

        // Assert
        Event::assertDispatched(MoneySubtracted::class, function ($event) use ($eventAccountUuid, $eventAmount) {
            return $event->accountUuid === $eventAccountUuid && $event->amount === $eventAmount;
        });
    }

    #[Test]
    public function testOnExpenseAdded()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BillingProjector($commandBus, $queryBus);
        Event::fake();
        $metaData = ['created-at' => Carbon::now()->toDateTimeString()];
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
        event($event);

        // Act
        Event::assertDispatched(ExpenseAdded::class, function ($event) use ($eventAccountUuid, $eventName, $eventAmount) {
            return $event->accountUuid === $eventAccountUuid && $event->name === $eventName && $event->amount === $eventAmount;
        });
        $queryBus->expects($this->atLeastOnce())->method('ask')->willReturn(serialize(new BillingData()));
        $commandBus->expects($this->atLeastOnce())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));
        $projector->onExpenseAdded($event);
    }

    #[Test]
    public function testOnExpenseCanceled()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BillingProjector($commandBus, $queryBus);
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
        Event::assertDispatched(ExpenseCanceled::class, function ($event) use ($eventAccountUuid, $eventName, $eventAmount, $eventId) {
            return $event->accountUuid === $eventAccountUuid && $event->name === $eventName && $event->amount === $eventAmount && $event->eventId === $eventId;
        });
        $queryBus->expects($this->atLeastOnce())->method('ask')->willReturn(serialize(new BillingData()));
        $commandBus->expects($this->atLeastOnce())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));
        $projector->onExpenseCanceled($event);
    }

    #[Test]
    public function testGetBilling()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BillingProjector($commandBus, $queryBus);

        // Act
        $queryBus->expects($this->once())->method('ask')->willReturn(serialize(new BillingData()));
        $result = $projector->getBillling(fake()->uuid());

        // Assert
        $this->assertInstanceOf(BillingData::class, $result);
    }

    #[Test]
    public function testGetBillingForNow()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new BillingProjector($commandBus, $queryBus);

        // Act
        $queryBus->expects($this->once())->method('ask')->willReturn(serialize(new BillingData()));
        $result = $projector->getBilllingForNow(fake()->uuid());

        // Assert
        $this->assertInstanceOf(MonthlyData::class, $result);
    }
}
