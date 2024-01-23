<?php

namespace Tests\Domains\Expense\Application\Mails;

use App\Domains\Expense\Application\Mails\ExpensesMail;
use App\Domains\User\Domain\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Mail\Mailables\Envelope;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExpensesMailTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testEnvelopeReturnsCorrectEnvelope()
    {
        // Mock data
        $user = new User();
        $user->email = 'user@example.com';
        $details = ['user' => $user, 'expenses' => []];

        // Creating ExpensesMail instance
        $mail = new ExpensesMail($details);

        // Execution
        $envelope = $mail->envelope();

        // Assertions
        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertEquals(env('MAIL_FROM_ADDRESS'), $envelope->from->address);
        $this->assertEquals(env('MAIL_FROM_NAME'), $envelope->from->name);
        $this->assertEquals(env('MAIL_REPLAYTO_ADDRESS'), $envelope->replyTo[0]->address);
        $this->assertEquals($user->email, $envelope->to[0]->address);
        $this->assertEquals(env('PROPERTY_ADDRESS', '') . ' - ' . ucfirst(__('recorded expense')), $envelope->subject);
    }

    #[Test]
    public function testBuildReturnsCorrectInstance()
    {
        // Mock data
        $user = new User();
        $user->email = 'user@example.com';
        $details = ['user' => $user, 'expenses' => []];

        // Creating ExpensesMail instance
        $mail = new ExpensesMail($details);

        // Execution
        $builtMail = $mail->build();

        // Assertions
        $this->assertInstanceOf(ExpensesMail::class, $builtMail);
        $this->assertEquals('email.expenses.daily.html', $builtMail->view);
        $this->assertEquals('email.expenses.daily.text', $builtMail->textView);
    }
}
