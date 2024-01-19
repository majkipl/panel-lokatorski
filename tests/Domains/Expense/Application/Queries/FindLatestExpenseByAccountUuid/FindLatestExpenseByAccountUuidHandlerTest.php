<?php

namespace Tests\Domains\Expense\Application\Queries\FindLatestExpenseByAccountUuid;

use App\Domains\Expense\Application\Queries\FindLatestExpenseByAccountUuid\FindLatestExpenseByAccountUuidHandler;
use App\Domains\Expense\Application\Queries\FindLatestExpenseByAccountUuid\FindLatestExpenseByAccountUuidQuery;
use App\Domains\Expense\Domain\Models\Expense;
use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindLatestExpenseByAccountUuidHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testHandle()
    {
        // Mock ExpenseRepositoryInterface
        $repositoryMock = $this->createMock(ExpenseRepositoryInterface::class);

        // UUID example
        $uuid = fake()->uuid();

        // Expected projection
        $expectedProjection = ['expense1', 'expense2']; // Example projection

        // Set up expectation for getLatestByAccountUuid method in ExpenseRepositoryInterface
        $repositoryMock->expects($this->once())
            ->method('getLatestByAccountUuid')
            ->with($this->equalTo($uuid)) // UUID
            ->willReturn(new Expense(['projection' => serialize($expectedProjection)]));

        // Create FindLatestExpenseByAccountUuidHandler instance with mocked ExpenseRepositoryInterface
        $handler = new FindLatestExpenseByAccountUuidHandler($repositoryMock);

        // Create FindLatestExpenseByAccountUuidQuery instance
        $query = new FindLatestExpenseByAccountUuidQuery($uuid);

        // Call handle method
        $result = $handler->handle($query);

        // Assert that the result is equal to the expected projection
        $this->assertEquals($expectedProjection, unserialize($result));
    }
}
