<?php

namespace App\Domains\Expense\Application\Mails;

use App\Domains\Billing\Application\Classes\MonthlyData;
use App\Domains\Billing\Application\Mails\BillingMail;
use App\Domains\User\Domain\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExpensesMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public User $user;

    /**
     * @var array
     */
    public array $expenses;

    /**
     * @var MonthlyData
     */
    public MonthlyData $billing;

    /**
     * @param $details
     */
    public function __construct(public $details)
    {
        $this->user = $this->details['user'];
        $this->expenses = $this->details['expenses'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $env = env('PROPERTY_ADDRESS', false);
        $property_name = $env ? $env . ' - ' : '';

        return new Envelope(
            from: new Address(
                address: env('MAIL_FROM_ADDRESS'),
                name: env('MAIL_FROM_NAME')
            ),
            to: $this->user->email,
            replyTo: env('MAIL_REPLAYTO_ADDRESS'),
            subject: $property_name . ucfirst(__('recorded expense'))
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * @return BillingMail
     */
    public function build(): ExpensesMail
    {
        return $this
            ->view('email.expenses.daily.html')
            ->text('email.expenses.daily.text');
    }
}
