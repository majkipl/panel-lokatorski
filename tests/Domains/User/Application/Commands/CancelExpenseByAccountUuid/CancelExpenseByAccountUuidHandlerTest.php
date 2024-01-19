<?php

namespace Tests\Domains\User\Application\Commands\CancelExpenseByAccountUuid;

use App\Domains\User\Application\Commands\CancelExpenseByAccountUuid\CancelExpenseByAccountUuidCommand;
use App\Domains\User\Application\Commands\CancelExpenseByAccountUuid\CancelExpenseByAccountUuidHandler;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CancelExpenseByAccountUuidHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        // Mock AccountRepositoryInterface
        $accountRepositoryMock = $this->createMock(AccountRepositoryInterface::class);

        $uuid = fake()->uuid();
        $id = fake()->randomNumber();

        // Set up expectation for cancelExpense method in AccountRepositoryInterface
        $accountRepositoryMock->expects($this->once())
            ->method('cancelExpense')
            ->with(
                $this->equalTo($uuid), // UUID
                $this->equalTo($id) // ID
            );

        // Create CancelExpenseByAccountUuidHandler instance with mocked AccountRepositoryInterface
        $handler = new CancelExpenseByAccountUuidHandler($accountRepositoryMock);

        // Create CancelExpenseByAccountUuidCommand instance
        $command = new CancelExpenseByAccountUuidCommand($uuid, $id);

        // Call handle method
        $handler->handle($command);
    }
}
