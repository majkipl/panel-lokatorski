<?php

namespace Tests\Domains\Balance\Application\Commands\UpdateProjection;

use App\Domains\Balance\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Balance\Application\Commands\UpdateProjection\UpdateProjectionHandler;
use App\Domains\Balance\Domain\Repositories\BalanceRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testHandle()
    {
        $uuid = fake()->uuid();
        $projection = fake()->word();

        // Mock BalanceRepositoryInterface
        $repositoryMock = $this->createMock(BalanceRepositoryInterface::class);

        // Set up the expected method calls
        $repositoryMock->expects($this->once())
            ->method('updateProjection')
            ->with(
                $this->equalTo($uuid),
                $this->equalTo($projection)
            )
            ->willReturn(true);

        // Create a new UpdateProjectionHandler instance with the mocked repository
        $handler = new UpdateProjectionHandler($repositoryMock);

        // Create a new UpdateProjectionCommand instance
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Call the handle method and assert the result
        $result = $handler->handle($command);
        $this->assertTrue($result);
    }
}
