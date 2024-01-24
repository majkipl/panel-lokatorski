<?php

namespace Tests\Domains\Expense\Application\Queries\FindAllByAccountUuid;

use App\Domains\Expense\Application\Queries\FindAllByAccountUuid\FindAllByAccountUuidHandler;
use App\Domains\Expense\Application\Queries\FindAllByAccountUuid\FindAllByAccountUuidQuery;
use App\Domains\Expense\Domain\Models\Expense;
use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindAllByAccountUuidHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $uuid = fake()->uuid();
        $expenses = [
            ['name' => 'Expense 1', 'amount' => 100, 'created_at' => Carbon::now()->subDays(2)],
            ['name' => 'Expense 2', 'amount' => 200, 'created_at' => Carbon::now()->subDays(1)],
            ['name' => 'Expense 3', 'amount' => 300, 'created_at' => Carbon::now()],
        ];
        $serializedExpenses = serialize($expenses);

        $expenseRepositoryMock = $this->createMock(ExpenseRepositoryInterface::class);
        $expenseRepositoryMock->expects($this->once())
            ->method('getLatestByAccountUuid')
            ->with($uuid)
            ->willReturn(new Expense(['projection' => $serializedExpenses]));

        $handler = new FindAllByAccountUuidHandler($expenseRepositoryMock);
        $query = new FindAllByAccountUuidQuery($uuid);

        // Act
        $result = $handler->handle($query);

        // Assert
        $this->assertIsArray($result);
        $this->assertCount(count($expenses), $result);

        $sortedExpenses = $expenses;
        usort($sortedExpenses, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });
        $this->assertEquals($sortedExpenses, $result);
    }
}
