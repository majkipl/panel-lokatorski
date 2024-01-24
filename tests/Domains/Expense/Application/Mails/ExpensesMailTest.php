<?php

namespace Tests\Domains\Expense\Application\Mails;

use App\Domains\Expense\Application\Mails\ExpensesMail;
use App\Domains\User\Domain\Models\User;
use Illuminate\Mail\Mailables\Envelope;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExpensesMailTest extends TestCase
{
    #[Test]
    public function testEnvelopeReturnsCorrectEnvelope()
    {
        // Arrange
        $email = fake()->safeEmail();
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('getAttribute')->with('email')->andReturn($email);
        $details = ['user' => $userMock, 'expenses' => []];

        // Act
        $mail = new ExpensesMail($details);
        $envelope = $mail->envelope();

        // Assertions
        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertEquals(env('MAIL_FROM_ADDRESS'), $envelope->from->address);
        $this->assertEquals(env('MAIL_FROM_NAME'), $envelope->from->name);
        $this->assertEquals(env('MAIL_REPLAYTO_ADDRESS'), $envelope->replyTo[0]->address);
        $this->assertEquals($email, $envelope->to[0]->address);
        $this->assertEquals(env('PROPERTY_ADDRESS', '') . ' - ' . ucfirst(__('recorded expense')), $envelope->subject);
    }

    #[Test]
    public function testBuildReturnsCorrectInstance()
    {
        // Arrange
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('getAttribute')->with('email')->andReturn('user@example.com');
        $details = ['user' => $userMock, 'expenses' => []];

        // Act
        // Creating ExpensesMail instance
        $mail = new ExpensesMail($details);
        $builtMail = $mail->build();

        // Assertions
        $this->assertInstanceOf(ExpensesMail::class, $builtMail);
        $this->assertEquals('email.expenses.daily.html', $builtMail->view);
        $this->assertEquals('email.expenses.daily.text', $builtMail->textView);
    }
}
