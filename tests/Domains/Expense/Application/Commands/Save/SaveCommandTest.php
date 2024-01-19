<?php

namespace Tests\Domains\Expense\Application\Commands\Save;

use App\Domains\Expense\Application\Commands\Save\SaveCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SaveCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstructorAndGetters()
    {
        $uuid = fake()->uuid();
        $projection = fake()->sentence(6);

        // Create SaveCommand instance
        $command = new SaveCommand($uuid, $projection);

        // Check if the getters return the expected values
        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
