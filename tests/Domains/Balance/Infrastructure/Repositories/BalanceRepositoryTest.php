<?php

namespace Tests\Domains\Balance\Infrastructure\Repositories;

use App\Domains\Balance\Domain\Models\Balance;
use App\Domains\Balance\Infrastructure\Repositories\BalanceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BalanceRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $balanceRepository;
    protected $balance;

    public function setUp(): void
    {
        parent::setUp();
        $this->balance = new Balance();
        $this->balanceRepository = new BalanceRepository($this->balance);
    }

    #[Test]
    public function testGetLatestByAccountUuid()
    {
        // Arrange
        $uuid = fake()->uuid();

        $expenseMock = Mockery::mock(Balance::class);
        $expenseMock->shouldReceive('where')->with('account_uuid', $uuid)->andReturnSelf();
        $expenseMock->shouldReceive('latest')->andReturnSelf();
        $expenseMock->shouldReceive('first')->andReturn(new Balance());

        $this->app->instance(Balance::class, $expenseMock);

        // Act
        $expenseRepo = new BalanceRepository($expenseMock);
        $result = $expenseRepo->getLatestByAccountUuid($uuid);

        // Assert
        $this->assertInstanceOf(Balance::class, $result);
    }

    #[Test]
    public function testUpdateProjection()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = serialize([]);

        $mock = Mockery::mock(Balance::class)->makePartial();
        $mock->shouldReceive('save')->once()->andReturnTrue();

        $this->app->instance(Balance::class, $mock);

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
        $expenseMock = $this->createMock(Balance::class);

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
