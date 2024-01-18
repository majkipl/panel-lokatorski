<?php

namespace Tests\Domains\Payment\Application\Projectors;

use App\Domains\Payment\Application\Projectors\PaymentProjector;
use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\User\Application\Projectors\AccountBalanceProjector;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Domains\User\Domain\Models\User;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PaymentProjectorTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = app(CommandBus::class);
        $this->queryBus = app(QueryBus::class);

        // Create PaymentProjector instance with mocked command bus and query bus
        $this->projector = new PaymentProjector($this->commandBus, $this->queryBus);
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

        $this->assertDatabaseHas('payments', ['account_uuid' => $user->refresh()->account->uuid]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testOnMoneyAdded()
    {
        // Get instance model
        $user = User::factory()->create();

        $event = new MoneyAdded(
            accountUuid: $user->account->uuid,
            amount: 100
        );

        event($event);

        $this->projector->onMoneyAdded(
            event: $event
        );

        $this->assertDatabaseHas('payments', ['account_uuid' => $user->refresh()->account->uuid]);

        //todo: assert data or count(payments)
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testOnMoneySubtracted()
    {
        // Get instance model
        $user = User::factory()->create();

        $event = new MoneySubtracted(
            accountUuid: $user->account->uuid,
            amount: 100
        );

        event($event);

        $this->projector->onMoneySubtracted(
            event: $event
        );

        $this->assertDatabaseHas('payments', ['account_uuid' => $user->refresh()->account->uuid]);

        //todo: assert data or count(payments)
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function testGetAllOperations()
    {
        // Get instance model
        $users = User::factory(3)->create();

        foreach ($users as $user) {
            $event = new MoneySubtracted(
                accountUuid: $user->account->uuid,
                amount: 100
            );

            event($event);

            $this->projector->onMoneySubtracted(
                event: $event
            );
        }

        foreach ($users as $user) {
            $payment = $user->refresh()->account->payments()->latest()->first();
            $this->assertEquals($payment->account_uuid, $user->account->uuid);
            $this->assertDatabaseHas('payments', ['account_uuid' => $user->refresh()->account->uuid]);
        }
    }
}
