<?php

namespace Tests\Domains\Balance\Application\Commands\Save;

use App\Domains\Balance\Application\Commands\Save\SaveCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testConstructorAndGetters()
    {
        $uuid = fake()->uuid();
        $projection = fake()->word();

        // Create a new SaveCommand instance
        $command = new SaveCommand($uuid, $projection);

        // Assert the uuid is set correctly
        $this->assertEquals($uuid, $command->getUuid());

        // Assert the projection is set correctly
        $this->assertEquals($projection, $command->getProjection());
    }
}
