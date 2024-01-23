<?php

namespace Tests\Domains\Expense\Application\Consoles;

use App\Domains\Expense\Application\Consoles\SendDailyExpenses;
use App\Domains\Expense\Application\Mails\ExpensesMail;
use App\Domains\Expense\Application\Projectors\ExpenseProjector;
use App\Domains\User\Domain\Models\Account;
use App\Domains\User\Domain\Models\User;
use App\Interfaces\Query\QueryBus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendDailyExpensesTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testHandleSendsExpensesEmails()
    {
        // Mocking dependencies
        $queryBus = Mockery::mock(QueryBus::class);
        $expenseProjector = Mockery::mock(ExpenseProjector::class);

        // Mock data
        $user1 = new User(['email' => 'user1@example.com', 'account' => new Account(['uuid' => 'uuid1'])]);
        $user2 = new User(['email' => 'user2@example.com', 'account' => new Account(['uuid' => 'uuid2'])]);
        $users = [$user1, $user2];

        // Expectations
        $queryBus->shouldReceive('ask')->once()->andReturn($users);
        $expenseProjector->shouldReceive('getTodaysExpenses')->times(count($users))->andReturn([]);

        // Setting up mail fake
        Mail::fake();

        // Creating SendDailyExpenses instance
        $command = new SendDailyExpenses();

        // Execution
        $command->handle($queryBus, $expenseProjector);

        // Assertions
        Mail::assertSent(ExpensesMail::class, function ($mail) use ($users) {
            foreach ($users as $user) {
                return $mail->hasTo($user->email);
            }
        });
    }
}
