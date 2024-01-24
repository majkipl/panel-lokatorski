<?php

namespace Tests\Domains\Expense\Application\Queries\FindLatestExpenseByAccountUuid;

use App\Domains\Expense\Application\Queries\FindLatestExpenseByAccountUuid\FindLatestExpenseByAccountUuidHandler;
use App\Domains\Expense\Application\Queries\FindLatestExpenseByAccountUuid\FindLatestExpenseByAccountUuidQuery;
use App\Domains\Expense\Domain\Models\Expense;
use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindLatestExpenseByAccountUuidHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $uuid = fake()->uuid();
        $expectedProjection = ['expense1', 'expense2'];
        $repositoryMock = $this->createMock(ExpenseRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('getLatestByAccountUuid')
            ->with($this->equalTo($uuid))
            ->willReturn(new Expense(['projection' => serialize($expectedProjection)]));
        $handler = new FindLatestExpenseByAccountUuidHandler($repositoryMock);
        $query = new FindLatestExpenseByAccountUuidQuery($uuid);

        // Act
        $result = $handler->handle($query);

        // Assert
        $this->assertEquals($expectedProjection, unserialize($result));
    }
}
