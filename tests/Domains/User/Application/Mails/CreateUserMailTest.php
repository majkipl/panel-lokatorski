<?php

namespace Tests\Domains\User\Application\Mails;

use App\Domains\User\Application\Mails\CreateUserMail;
use App\Domains\User\Domain\Models\User;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateUserMailTest extends TestCase
{

    #[Test]
    public function test_mail_is_created_with_correct_details()
    {
        // Arrange
        $user_id = fake()->randomNumber();

        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('getAttribute')->with('id')->andReturn($user_id);
        $userMock->shouldReceive('setAttribute');

        // Act
        // Create mail instance
        $mail = new CreateUserMail(['user' => $userMock]);

        // Assert
        // Check if user property is set correctly
        $this->assertInstanceOf(User::class, $mail->user);
        $this->assertEquals($user_id, $mail->user->id);
    }

    #[Test]
    public function test_mail_is_built_with_correct_view_and_text()
    {
        // Arrange
        $userMock = Mockery::mock(User::class);

        // Act
        // Create mail instance
        $mail = new CreateUserMail(['user' => $userMock]);
        $builtMail = $mail->build();

        // Assert
        // Check if correct view is set
        $this->assertEquals('email.user.created.html', $builtMail->view);
        $this->assertEquals('email.user.created.text', $builtMail->textView);
    }

    #[Test]
    public function test_mail_envelope_is_correct()
    {
        // Arrange
        $userMock = Mockery::mock(User::class);

        // Act
        // Create mail instance
        $mail = new CreateUserMail(['user' => $userMock]);
        $envelope = $mail->envelope();

        // Assert
        // Check if envelope properties are correct
        $this->assertEquals(env('MAIL_FROM_ADDRESS'), $envelope->from->address);
        $this->assertEquals(env('MAIL_FROM_NAME'), $envelope->from->name);
        $this->assertEquals(env('MAIL_REPLAYTO_ADDRESS'), $envelope->replyTo[0]->address);
        $this->assertEquals(env('PROPERTY_ADDRESS', '') . ' - ' . __('A new user has been registered'), $envelope->subject);
    }
}
