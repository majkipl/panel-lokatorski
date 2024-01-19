<?php

namespace Tests\Domains\Expense\Application\Commands\Save;

use App\Domains\Expense\Application\Commands\Save\SaveCommand;
use App\Domains\Expense\Application\Commands\Save\SaveHandler;
use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testHandle()
    {
        // Mock ExpenseRepositoryInterface
        $repositoryMock = $this->createMock(ExpenseRepositoryInterface::class);

        $uuid = fake()->uuid();
        $projection = fake()->sentence(6);

        // Set up expectation for save method in ExpenseRepositoryInterface
        $repositoryMock->expects($this->once())
            ->method('save')
            ->with(
                $this->equalTo($uuid), // UUID
                $this->equalTo($projection) // Projection
            )
            ->willReturn(true); // Mocking the return value

        // Create SaveHandler instance with mocked ExpenseRepositoryInterface
        $handler = new SaveHandler($repositoryMock);

        // Create SaveCommand instance
        $command = new SaveCommand($uuid, $projection);

        // Call handle method
        $result = $handler->handle($command);

        // Assert that the handle method returns true
        $this->assertTrue($result);
    }
}
