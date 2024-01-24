<?php

namespace Tests\Domains\User\Application\Projectors;

use App\Domains\User\Application\Commands\SaveAccount\SaveAccountCommand;
use App\Domains\User\Application\Projectors\AccountBalanceProjector;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountBalanceProjectorTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testOnAccountCreated()
    {
        // Arrange
        $commandBus = $this->createMock(CommandBus::class);
        $queryBus = $this->createMock(QueryBus::class);
        $projector = new AccountBalanceProjector($commandBus, $queryBus);
        Event::fake();
        $accountAttributes = ['user_id' => fake()->randomNumber()];
        $event = new AccountCreated($accountAttributes);

        // Act
        event($event);

        // Assert
        Event::assertDispatched(AccountCreated::class, function ($event) use ($accountAttributes) {
            return $event->accountAttributes['user_id'] === $accountAttributes['user_id'];
        });
        $queryBus->expects($this->once())->method('ask')->willReturn(false);
        $commandBus->expects($this->once())->method('dispatch')->with($this->isInstanceOf(SaveAccountCommand::class));
        $projector->onAccountCreated($event);
    }
}
