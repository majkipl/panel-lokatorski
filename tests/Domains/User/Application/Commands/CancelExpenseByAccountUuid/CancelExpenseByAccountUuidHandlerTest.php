<?php

namespace Tests\Domains\User\Application\Commands\CancelExpenseByAccountUuid;

use App\Domains\User\Application\Commands\CancelExpenseByAccountUuid\CancelExpenseByAccountUuidCommand;
use App\Domains\User\Application\Commands\CancelExpenseByAccountUuid\CancelExpenseByAccountUuidHandler;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CancelExpenseByAccountUuidHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $uuid = fake()->uuid();
        $id = fake()->randomNumber();
        $accountRepositoryMock = $this->createMock(AccountRepositoryInterface::class);
        $accountRepositoryMock->expects($this->once())
            ->method('cancelExpense')
            ->with(
                $this->equalTo($uuid), // UUID
                $this->equalTo($id) // ID
            );

        // Act
        $handler = new CancelExpenseByAccountUuidHandler($accountRepositoryMock);
        $command = new CancelExpenseByAccountUuidCommand($uuid, $id);

        $handler->handle($command);

        // Assert
        // No direct assertions needed; the expectation on the mock suffices.
    }
}
