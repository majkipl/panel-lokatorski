<?php

namespace Tests\Domains\Payment\Application\Projectors;

use App\Domains\Payment\Application\Commands\Save\SaveCommand;
use App\Domains\Payment\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Payment\Application\Projectors\PaymentProjector;
use App\Domains\Payment\Application\Queries\FindLatestPayments\FindAllLatestPaymentsQuery;
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

class PaymentProjectorTest extends TestCase
{

    #[Test]
    public function testOnAccountCreated()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);

        $projector = new PaymentProjector($commandBus, $queryBus);

        Event::fake();

        $accountAttributes = ['uuid' => fake()->uuid()];
        $event = new AccountCreated($accountAttributes);

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
    public function testOnMoneyAdded()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);

        $projector = new PaymentProjector($commandBus, $queryBus);

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

        $queryBus->expects($this->exactly(2))->method('ask')->willReturnOnConsecutiveCalls(serialize([]), new User());
        $commandBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));

        $projector->onMoneyAdded($event);
    }

    #[Test]
    public function testOnMoneySubtracted()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);

        $projector = new PaymentProjector($commandBus, $queryBus);

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

        $queryBus->expects($this->exactly(2))->method('ask')->willReturnOnConsecutiveCalls(serialize([]), new User());
        $commandBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(UpdateProjectionCommand::class));

        $projector->onMoneySubtracted($event);
    }

    #[Test]
    public function testGetAllOperations()
    {
        // Arrange
        // Mock CommandBus and QueryBus
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);

        $projector = new PaymentProjector($commandBus, $queryBus);

        // Act
        $queryBus->expects($this->once())
            ->method('ask')
            ->with($this->isInstanceOf(FindAllLatestPaymentsQuery::class))
            ->willReturn([]);

        $operations = $projector->getAllOperations();

        $this->assertIsArray($operations);
    }
}
