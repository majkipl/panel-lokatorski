<?php

namespace Tests\Domains\Billing\Application\Consoles;

use App\Domains\Billing\Application\Classes\MonthlyData;
use App\Domains\Billing\Application\Consoles\SendMonthlyBilling;
use App\Domains\Billing\Application\Mails\BillingMail;
use App\Domains\Billing\Application\Projectors\BillingProjector;
use App\Domains\Expense\Application\Projectors\ExpenseProjector;
use App\Domains\User\Domain\Models\Account;
use App\Domains\User\Domain\Models\User;
use App\Interfaces\Query\QueryBus;
use Illuminate\Support\Facades\Mail;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendMonthlyBillingTest extends TestCase
{
    #[Test]
    public function testHandleSendsBillingEmails()
    {
        // Arrange
        $queryBus = Mockery::mock(QueryBus::class);
        $expenseProjector = Mockery::mock(ExpenseProjector::class);
        $billingProjector = Mockery::mock(BillingProjector::class);

        $user1 = new User(['email' => 'user1@example.com', 'account' => new Account(['uuid' => 'uuid1'])]);
        $user2 = new User(['email' => 'user2@example.com', 'account' => new Account(['uuid' => 'uuid2'])]);
        $users = [$user1, $user2];

        $queryBus->shouldReceive('ask')->once()->andReturn($users);
        $expenseProjector->shouldReceive('getExpensesForNow')->times(count($users))->andReturn([]);
        $billingProjector->shouldReceive('getBilllingForNow')->times(count($users))->andReturn(new MonthlyData());

        // Setting up mail fake
        Mail::fake();

        // Creating SendMonthlyBilling instance
        $command = new SendMonthlyBilling();

        // Act
        $command->handle($queryBus, $expenseProjector, $billingProjector);

        // Assertions
        Mail::assertSent(BillingMail::class, function ($mail) use ($users) {
            foreach ($users as $user) {
                return $mail->hasTo($user->email);
            }
        });
    }
}
