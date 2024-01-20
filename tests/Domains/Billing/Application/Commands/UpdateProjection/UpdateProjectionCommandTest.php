<?php

namespace Tests\Domains\Billing\Application\Commands\UpdateProjection;

use App\Domains\Billing\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testConstructorAndGetters()
    {
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        // Create UpdateProjectionCommand instance
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Assert that the UUID and projection returned by getter methods match the values provided in the constructor
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
