<?php

namespace Tests\Domains\Billing\Application\Mails;

use App\Domains\Billing\Application\Classes\MonthlyData;
use App\Domains\Billing\Application\Mails\BillingMail;
use App\Domains\User\Domain\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Mail\Mailables\Envelope;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BillingMailTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testEnvelopeReturnsCorrectEnvelope()
    {
        // Mock data
        $user = new User();
        $user->email = 'user@example.com';
        $monthlyData = new MonthlyData();
        $monthlyData->setPayment(100);
        $monthlyData->setExpense(50);
        $monthlyData->setBalance(50);

        $details = [
            'user' => $user,
            'expenses' => [],
            'billing' => $monthlyData,
        ];

        // Creating BillingMail instance
        $mail = new BillingMail($details);

        // Execution
        $envelope = $mail->envelope();

        // Assertions
        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertEquals(env('MAIL_FROM_ADDRESS'), $envelope->from->address);
        $this->assertEquals(env('MAIL_FROM_NAME'), $envelope->from->name);
        $this->assertEquals(env('MAIL_REPLAYTO_ADDRESS'), $envelope->replyTo[0]->address);
        $this->assertEquals($user->email, $envelope->to[0]->address);
        $expectedSubject = env('PROPERTY_ADDRESS', '') . ' - ' . __('billing for') . ' ' . Carbon::now()->locale('pl')->isoFormat('MMMM') . ' ' . Carbon::now()->year;
        $this->assertEquals($expectedSubject, $envelope->subject);
    }

    #[Test]
    public function testBuildReturnsCorrectInstance()
    {
        // Mock data
        $user = new User();
        $user->email = 'user@example.com';
        $monthlyData = new MonthlyData();
        $monthlyData->setPayment(100);
        $monthlyData->setExpense(50);
        $monthlyData->setBalance(50);
        $details = [
            'user' => $user,
            'expenses' => [],
            'billing' => $monthlyData,
        ];

        // Creating BillingMail instance
        $mail = new BillingMail($details);

        // Execution
        $builtMail = $mail->build();

        // Assertions
        $this->assertInstanceOf(BillingMail::class, $builtMail);
        $this->assertEquals('email.billing.monthly.html', $builtMail->view);
        $this->assertEquals('email.billing.monthly.text', $builtMail->textView);
    }
}
