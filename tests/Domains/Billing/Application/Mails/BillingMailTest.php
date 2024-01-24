<?php

namespace Tests\Domains\Billing\Application\Mails;

use App\Domains\Billing\Application\Classes\MonthlyData;
use App\Domains\Billing\Application\Mails\BillingMail;
use App\Domains\User\Domain\Models\User;
use Carbon\Carbon;
use Illuminate\Mail\Mailables\Envelope;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BillingMailTest extends TestCase
{
    #[Test]
    public function testEnvelopeReturnsCorrectEnvelope()
    {
        // Arrange
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('getAttribute')->with('email')->andReturn('user@example.com');

        $monthlyDataMock = Mockery::mock(MonthlyData::class);
        $monthlyDataMock->shouldReceive('getPayment')->andReturn(100);
        $monthlyDataMock->shouldReceive('getExpense')->andReturn(50);
        $monthlyDataMock->shouldReceive('getBalance')->andReturn(50);

        $details = [
            'user' => $userMock,
            'expenses' => [],
            'billing' => $monthlyDataMock,
        ];

        // Act
        // Creating BillingMail instance
        $mail = new BillingMail($details);
        $envelope = $mail->envelope();

        // Assertions
        $expectedSubject = env('PROPERTY_ADDRESS', '') . ' - ' . __('billing for') . ' ' . Carbon::now()->locale('pl')->isoFormat('MMMM') . ' ' . Carbon::now()->year;
        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertEquals(env('MAIL_FROM_ADDRESS'), $envelope->from->address);
        $this->assertEquals(env('MAIL_FROM_NAME'), $envelope->from->name);
        $this->assertEquals(env('MAIL_REPLAYTO_ADDRESS'), $envelope->replyTo[0]->address);
        $this->assertEquals('user@example.com', $envelope->to[0]->address);
        $this->assertEquals($expectedSubject, $envelope->subject);
    }

    #[Test]
    public function testBuildReturnsCorrectInstance()
    {
        // Arrange
        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('getAttribute')->with('email')->andReturn('user@example.com');

        $monthlyDataMock = Mockery::mock(MonthlyData::class);
        $monthlyDataMock->shouldReceive('getPayment')->andReturn(100);
        $monthlyDataMock->shouldReceive('getExpense')->andReturn(50);
        $monthlyDataMock->shouldReceive('getBalance')->andReturn(50);

        $details = [
            'user' => $userMock,
            'expenses' => [],
            'billing' => $monthlyDataMock,
        ];

        // Act
        // Creating BillingMail instance
        $mail = new BillingMail($details);
        $builtMail = $mail->build();

        // Assertions
        $this->assertInstanceOf(BillingMail::class, $builtMail);
        $this->assertEquals('email.billing.monthly.html', $builtMail->view);
        $this->assertEquals('email.billing.monthly.text', $builtMail->textView);
    }
}
