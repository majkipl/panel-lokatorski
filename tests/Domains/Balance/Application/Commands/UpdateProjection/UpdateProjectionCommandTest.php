<?php

namespace Tests\Domains\Balance\Application\Commands\UpdateProjection;

use App\Domains\Balance\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testGetters()
    {
        $uuid = fake()->uuid();
        $projection = fake()->word();

        // Create a new UpdateProjectionCommand instance
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Call the getters and assert the results
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
