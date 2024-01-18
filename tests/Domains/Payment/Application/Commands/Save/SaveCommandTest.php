<?php

namespace Tests\Domains\Payment\Application\Commands\Save;

use App\Domains\Payment\Application\Commands\Save\SaveCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SaveCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstructionAndGetters()
    {
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        $command = new SaveCommand($uuid, $projection);

        $this->assertInstanceOf(SaveCommand::class, $command);
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
