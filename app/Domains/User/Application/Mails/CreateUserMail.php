<?php

namespace App\Domains\User\Application\Mails;

use App\Domains\User\Application\Queries\FindEmailsByUserRoleAndStatus\FindEmailsByUserRoleAndStatusQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Models\User;
use App\Interfaces\Query\QueryBus;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public User $user;

    protected QueryBus $bus;

    /**
     * @param $details
     */
    public function __construct(public $details)
    {
        $this->user = $this->details['user'];
        $this->bus = app(QueryBus::class);
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $env = env('PROPERTY_ADDRESS', false);
        $property_name = $env ? $env . ' - ' : '';

        $admins = $this->bus->ask(
            query: new FindEmailsByUserRoleAndStatusQuery(
                status: UserStatus::ACTIVE,
                role: [UserRole::ADMIN]
            )
        );

        if(empty($admins)) {
            throw new Exception('No admins to send email to.');
        }

        return new Envelope(
            from: new Address(
                address: env('MAIL_FROM_ADDRESS'),
                name: env('MAIL_FROM_NAME')
            ),
            to: $admins,
            replyTo: env('MAIL_REPLAYTO_ADDRESS'),
            subject: $property_name . __('A new user has been registered'),
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
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
