<?php

namespace Tests\Domains\Payment\Application\Commands\UpdateProjection;

use App\Domains\Payment\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateProjectionCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstructionAndGetters()
    {
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        $command = new UpdateProjectionCommand($uuid, $projection);

        $this->assertInstanceOf(UpdateProjectionCommand::class, $command);
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
