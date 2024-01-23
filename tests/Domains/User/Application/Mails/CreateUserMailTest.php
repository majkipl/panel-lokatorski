<?php

namespace Domains\User\Application\Mails;

use App\Domains\User\Application\Mails\CreateUserMail;
use App\Domains\User\Domain\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserMailTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_mail_is_created_with_correct_details()
    {
        // Mock user
        $user = User::factory()->create();

        // Create mail instance
        $mail = new CreateUserMail(['user' => $user]);

        // Check if user property is set correctly
        $this->assertInstanceOf(User::class, $mail->user);
        $this->assertEquals($user->id, $mail->user->id);
        // Add more assertions for other properties if needed
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_mail_is_built_with_correct_view_and_text()
    {
        // Mock user
        $user = User::factory()->create();

        // Create mail instance
        $mail = new CreateUserMail(['user' => $user]);

        // Build the mail
        $builtMail = $mail->build();

        // Check if correct view is set
        $this->assertEquals('email.user.created.html', $builtMail->view);
        $this->assertEquals('email.user.created.text', $builtMail->textView);
        // Add more assertions for other methods if needed
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_mail_envelope_is_correct()
    {
        // Mock user
        $user = User::factory()->create();

        // Create mail instance
        $mail = new CreateUserMail(['user' => $user]);

        // Get the mail envelope
        $envelope = $mail->envelope();

        // Check if envelope properties are correct
        $this->assertEquals(env('MAIL_FROM_ADDRESS'), $envelope->from->address);
        $this->assertEquals(env('MAIL_FROM_NAME'), $envelope->from->name);
        $this->assertEquals(env('MAIL_REPLAYTO_ADDRESS'), $envelope->replyTo[0]->address);
        $this->assertEquals('Legnicka 55b/5 - A new user has been registered', $envelope->subject);
    }
}
