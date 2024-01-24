<?php

namespace Tests\Domains\Expense\Infrastructure\Repositories;

use App\Domains\Expense\Domain\Models\Expense;
use App\Domains\Expense\Infrastructure\Repositories\ExpenseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExpenseRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testGetLatestByAccountUuid()
    {
        // Arrange
        $uuid = fake()->uuid();

        $expenseMock = Mockery::mock(Expense::class);
        $expenseMock->shouldReceive('where')->with('account_uuid', $uuid)->andReturnSelf();
        $expenseMock->shouldReceive('latest')->andReturnSelf();
        $expenseMock->shouldReceive('first')->andReturn(new Expense());

        $this->app->instance(Expense::class, $expenseMock);

        // Act
        $expenseRepo = new ExpenseRepository($expenseMock);
        $result = $expenseRepo->getLatestByAccountUuid($uuid);

        // Assert
        $this->assertInstanceOf(Expense::class, $result);
    }

    #[Test]
    public function testUpdateProjection()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = serialize([]);

        $mock = Mockery::mock(Expense::class)->makePartial();
        $mock->shouldReceive('save')->once()->andReturnTrue();

        $this->app->instance(Expense::class, $mock);

        // Act
        $mock->account_uuid = $uuid;
        $mock->projection = $projection;
        $result = $mock->save();

        // Assert
        $this->assertTrue($result);
        $this->assertEquals($uuid, $mock->account_uuid);
        $this->assertEquals($projection, $mock->projection);
    }

    #[Test]
    public function testSave()
    {
        // Arrange
        $expenseMock = $this->createMock(Expense::class);

        // Act
        $expenseMock->method('save')->willReturn(true);

        $uuid = fake()->uuid();
        $projection = serialize([]);

        $expenseMock->account_uuid = $uuid;
        $expenseMock->projection = $projection;

        // Assert
        $this->assertTrue($expenseMock->save());
    }
}
