<?php

namespace Tests\Domains\Expense\Application\Commands\UpdateProjection;

use App\Domains\Expense\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Expense\Application\Commands\UpdateProjection\UpdateProjectionHandler;
use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence(6);
        $repositoryMock = $this->createMock(ExpenseRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('updateProjection')
            ->with(
                $this->equalTo($uuid), // UUID
                $this->equalTo($projection) // Projection
            )
            ->willReturn(true);

        $handler = new UpdateProjectionHandler($repositoryMock);
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Act
        $result = $handler->handle($command);

        // Assert
        $this->assertTrue($result);
    }
}
