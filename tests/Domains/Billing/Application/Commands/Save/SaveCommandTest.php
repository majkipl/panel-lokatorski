<?php

namespace Tests\Domains\Billing\Application\Commands\Save;

use App\Domains\Billing\Application\Commands\Save\SaveCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testConstructor()
    {
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        $command = new SaveCommand($uuid, $projection);

        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($projection, $command->getProjection());
    }
}
