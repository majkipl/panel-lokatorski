<?php

namespace Tests\Domains\Expense\Application\Commands\UpdateProjection;

use App\Domains\Expense\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Expense\Application\Commands\UpdateProjection\UpdateProjectionHandler;
use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testHandle()
    {
        // Mock ExpenseRepositoryInterface
        $repositoryMock = $this->createMock(ExpenseRepositoryInterface::class);

        $uuid = fake()->uuid();
        $projection = fake()->sentence(6);

        // Set up expectation for updateProjection method in ExpenseRepositoryInterface
        $repositoryMock->expects($this->once())
            ->method('updateProjection')
            ->with(
                $this->equalTo($uuid), // UUID
                $this->equalTo($projection) // Projection
            )
            ->willReturn(true);

        // Create UpdateProjectionHandler instance with mocked ExpenseRepositoryInterface
        $handler = new UpdateProjectionHandler($repositoryMock);

        // Create UpdateProjectionCommand instance
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Call handle method and assert that it returns true
        $this->assertTrue($handler->handle($command));
    }
}
