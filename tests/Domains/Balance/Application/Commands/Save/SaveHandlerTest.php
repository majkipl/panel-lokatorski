<?php

namespace Tests\Domains\Balance\Application\Commands\Save;

use App\Domains\Balance\Application\Commands\Save\SaveCommand;
use App\Domains\Balance\Application\Commands\Save\SaveHandler;
use App\Domains\Balance\Domain\Repositories\BalanceRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testHandle()
    {
        $uuid = fake()->uuid();
        $projection = fake()->word();

        // Create a mock BalanceRepositoryInterface
        $repositoryMock = $this->createMock(BalanceRepositoryInterface::class);

        // Set up the expected method calls
        $repositoryMock->expects($this->once())
            ->method('save')
            ->with(
                $this->equalTo($uuid),
                $this->equalTo($projection)
            )
            ->willReturn(true);

        // Create a new SaveHandler instance with the mock repository
        $handler = new SaveHandler($repositoryMock);

        // Create a new SaveCommand instance
        $command = new SaveCommand($uuid, $projection);

        // Call the handle method and assert the result
        $result = $handler->handle($command);
        $this->assertTrue($result);
    }
}
