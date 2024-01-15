<?php

namespace App\Domains\User\Application\Mails;

use App\Domains\User\Domain\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public User $user;

    /**
     * @param $details
     */
    public function __construct(public $details)
    {
        $this->user = $this->details['user'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                address: env('MAIL_FROM_ADDRESS'),
                name: env('MAIL_FROM_NAME')
            ),
            to: $this->user->email,
            replyTo: env('MAIL_REPLAYTO_ADDRESS'),
            subject: 'Legnicka 55b/5 - ' . __('A new user has been registered'),
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
     * @return CreateUserMail
     */
    public function build(): CreateUserMail
    {
        return $this
            ->view('email.user.created.html')
            ->text('email.user.created.text');
    }
}
