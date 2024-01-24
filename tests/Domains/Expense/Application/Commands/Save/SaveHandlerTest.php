<?php

namespace Tests\Domains\Expense\Application\Commands\Save;

use App\Domains\Expense\Application\Commands\Save\SaveCommand;
use App\Domains\Expense\Application\Commands\Save\SaveHandler;
use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence(6);

        $repositoryMock = $this->createMock(ExpenseRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('save')
            ->with(
                $this->equalTo($uuid),
                $this->equalTo($projection)
            )
            ->willReturn(true);

        $handler = new SaveHandler($repositoryMock);
        $command = new SaveCommand($uuid, $projection);

        // Act
        $result = $handler->handle($command);

        // Assert
        $this->assertTrue($result);
    }
}
