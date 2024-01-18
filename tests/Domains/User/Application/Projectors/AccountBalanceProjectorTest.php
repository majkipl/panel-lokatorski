<?php

namespace Tests\Domains\User\Application\Projectors;

use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\User\Application\Projectors\AccountBalanceProjector;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Domains\User\Domain\Models\User;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AccountBalanceProjectorTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_account_created_event_and_creates_new_account()
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

        // Act
        $projector->onAccountCreated($event);

        // Assert
        $this->assertDatabaseHas('accounts', ['user_id' => $user->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_account_created_event_and_updates_existing_account_balance_to_zero()
    {
        // Get instance model
        $user = User::factory()->create();

        // Arrange
        $existingAccount = $user->account;
        $projector = new AccountBalanceProjector();
        $event = new AccountCreated(['user_id' => $user->id]);

        // Act
        $projector->onAccountCreated($event);

        // Assert
        $this->assertEquals(0, $existingAccount->refresh()->balance);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_money_added_event_and_updates_account_balance()
    {
        // Get instance model
        $user = User::factory()->create();

        // Arrange
        $amount = 100;
        $projector = new AccountBalanceProjector();
        $event = new MoneyAdded($user->account->uuid, $amount);

        // Act
        $projector->onMoneyAdded($event);

        // Assert
        $this->assertEquals($amount, $user->account->refresh()->balance);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_money_subtracted_event_and_updates_account_balance()
    {
        // Arrange
        $user = User::factory()->create();
        $balance = $user->account->balanse;
        $amount = 100;
        $projector = new AccountBalanceProjector();
        $event = new MoneySubtracted($user->account->uuid, $amount);

        // Act
        $projector->onMoneySubtracted($event);

        // Assert
        $this->assertEquals($balance - $amount, $user->account->refresh()->balance);
    }
}
