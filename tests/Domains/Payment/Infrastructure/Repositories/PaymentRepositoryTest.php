<?php

namespace Tests\Domains\Payment\Infrastructure\Repositories;

use App\Domains\Payment\Domain\Models\Payment;
use App\Domains\Payment\Infrastructure\Repositories\PaymentRepository;
use App\Domains\User\Application\Commands\AddMoneyByUserId\AddMoneyByUserIdCommand;
use App\Domains\User\Domain\Models\User;
use App\Interfaces\Command\CommandBus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PaymentRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testGetLatestByAccountUuid()
    {
        $user = User::factory()->create();
        $amount = 100;

        $commandBus = app(CommandBus::class);

        $commandBus->dispatch(
            command: new AddMoneyByUserIdCommand(
                id: $user->id,
                amount: $amount
            )
        );

        // Create PaymentRepository instance
        $repository = new PaymentRepository(new Payment());

        // Retrieve the latest payment by account UUID
        $latestPayment = $repository->getLatestByAccountUuid($user->account->uuid);

        $payments = unserialize($latestPayment->projection);
        $payment = reset($payments);

        $this->assertCount(1, $payments);
        $this->assertEquals($amount, $payment['amount']);
        $this->assertEquals($user->account->uuid, $payment['accountUuid']);
    }

    #[Test]
    public function testGetLatest()
    {
        //todo: modify test on mock
        $users = User::factory(3)->create();

        foreach ($users as $user) {
            $amount = 100;

            $commandBus = app(CommandBus::class);

            $commandBus->dispatch(
                command: new AddMoneyByUserIdCommand(
                    id: $user->id,
                    amount: $amount
                )
            );
        }

        // Create PaymentRepository instance
        $repository = new PaymentRepository(new Payment());

        // Retrieve the latest payments
        $latestPayments = $repository->getLatest();

        $this->assertCount(count($users), $latestPayments);

        foreach ($latestPayments as $index => $item) {

            $payment = unserialize($item->projection);

            $this->assertEquals($amount, $payment[0]['amount']);
            $this->assertEquals($users[$index]->account->uuid, $payment[0]['accountUuid']);
        }
    }

    #[Test]
    public function testUpdateProjection()
    {
        $user = User::factory()->create();

        // Create PaymentRepository instance
        $repository = new PaymentRepository(new Payment());

        sleep(1);

        // Update the projection of the test payment
        $updated = $repository->updateProjection($user->account->uuid, 'new_projection');

        // Assert that the update operation was successful
        $this->assertTrue($updated);

        // Retrieve the payment after update
        $updatedPayment = Payment::where('account_uuid', $user->account->uuid)->latest()->first();

        // Assert that the projection of the updated payment matches the new projection value
        $this->assertEquals('new_projection', $updatedPayment->projection);
    }

    #[Test]
    public function testSave()
    {
        $user = User::factory()->create();

        // Create PaymentRepository instance
        $repository = new PaymentRepository(new Payment());

        sleep(1);

        // Save a new payment
        $saved = $repository->save($user->account->uuid, 'test_projection');

        // Assert that the save operation was successful
        $this->assertTrue($saved);

        // Retrieve the saved payment
        $savedPayment = Payment::where('account_uuid', $user->account->uuid)->latest()->first();

        // Assert that the retrieved payment is not null
        $this->assertNotNull($savedPayment);

        // Assert that the projection of the saved payment matches the provided projection value
        $this->assertEquals('test_projection', $savedPayment->projection);
    }
}
