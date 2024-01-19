<?php

namespace Tests\Domains\Expense\Application\Queries\FindAllByAccountUuid;

use App\Domains\Expense\Application\Queries\FindAllByAccountUuid\FindAllByAccountUuidHandler;
use App\Domains\Expense\Application\Queries\FindAllByAccountUuid\FindAllByAccountUuidQuery;
use App\Domains\Expense\Domain\Models\Expense;
use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindAllByAccountUuidHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testHandle()
    {
        // Mock ExpenseRepositoryInterface
        $expenseRepositoryMock = $this->createMock(ExpenseRepositoryInterface::class);

        // UUID example
        $uuid = fake()->uuid();

        // Mock expenses data
        $expenses = [
            ['name' => 'Expense 1', 'amount' => 100, 'created_at' => Carbon::now()->subDays(2)],
            ['name' => 'Expense 2', 'amount' => 200, 'created_at' => Carbon::now()->subDays(1)],
            ['name' => 'Expense 3', 'amount' => 300, 'created_at' => Carbon::now()],
        ];

        // Serialize expenses data
        $serializedExpenses = serialize($expenses);

        // Set up expectation for getLatestByAccountUuid method in ExpenseRepositoryInterface
        $expenseRepositoryMock->expects($this->once())
            ->method('getLatestByAccountUuid')
            ->with($uuid)
            ->willReturn(new Expense(['projection' => $serializedExpenses]));

        // Create FindAllByAccountUuidHandler instance with mocked ExpenseRepositoryInterface
        $handler = new FindAllByAccountUuidHandler($expenseRepositoryMock);

        // Create FindAllByAccountUuidQuery instance
        $query = new FindAllByAccountUuidQuery($uuid);

        // Call handle method
        $result = $handler->handle($query);

        // Assert that the result is an array
        $this->assertIsArray($result);

        // Assert that the result contains the correct number of expenses
        $this->assertCount(count($expenses), $result);

        // Assert that the result is sorted by created_at in descending order
        $sortedExpenses = $expenses;
        usort($sortedExpenses, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });
        $this->assertEquals($sortedExpenses, $result);
    }
}
