<?php

namespace Tests\Domains\User\Application\Commands\CancelExpenseByAccountUuid;

use App\Domains\User\Application\Commands\CancelExpenseByAccountUuid\CancelExpenseByAccountUuidCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CancelExpenseByAccountUuidCommandTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testConstruction()
    {
        $uuid = fake()->uuid();
        $id = fake()->randomNumber();

        $command = new CancelExpenseByAccountUuidCommand($uuid, $id);

        $this->assertEquals($uuid, $command->getUuid());
        $this->assertEquals($id, $command->getId());
    }
}
