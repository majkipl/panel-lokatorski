<?php

namespace Tests\Domains\Expense\Application\Commands\UpdateProjection;

use App\Domains\Expense\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testConstructorAndMethods()
    {
        $uuid = fake()->uuid();
        $projection = fake()->sentence(6);

        // Create UpdateProjectionCommand instance
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Assert that the getUuid() method returns the correct value
        $this->assertEquals($uuid, $command->getUuid());

        // Assert that the getProjection() method returns the correct value
        $this->assertEquals($projection, $command->getProjection());
    }
}
