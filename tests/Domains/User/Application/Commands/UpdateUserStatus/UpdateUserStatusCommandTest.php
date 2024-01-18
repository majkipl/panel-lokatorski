<?php

namespace Tests\Domains\User\Application\Commands\UpdateUserStatus;

use App\Domains\User\Application\Commands\UpdateUserStatus\UpdateUserStatusCommand;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateUserStatusCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstruction()
    {
        $id = User::factory()->create()->id;
        $status = UserStatus::ACTIVE->value;
        $command = new UpdateUserStatusCommand($id, $status);

        $this->assertInstanceOf(UpdateUserStatusCommand::class, $command);
        $this->assertEquals($id, $command->getId());
        $this->assertEquals($status, $command->getStatus());
    }
}
