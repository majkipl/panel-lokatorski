<?php

namespace Tests\Domains\Billing\Infrastructure\Repositories;

use App\Domains\Billing\Application\Classes\BillingData;
use App\Domains\Billing\Domain\Models\Billing;
use App\Domains\Billing\Infrastructure\Repositories\BillingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BillingRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $billingRepository;
    protected $billing;

    public function setUp(): void
    {
        parent::setUp();
        $this->billing = new Billing();
        $this->billingRepository = new BillingRepository($this->billing);
    }

    #[Test]
    public function testGetLatestByAccountUuid()
    {
        // Arrange
        $uuid = fake()->uuid();

        $expenseMock = Mockery::mock(Billing::class);
        $expenseMock->shouldReceive('where')->with('account_uuid', $uuid)->andReturnSelf();
        $expenseMock->shouldReceive('latest')->andReturnSelf();
        $expenseMock->shouldReceive('first')->andReturn(new Billing());

        $this->app->instance(Billing::class, $expenseMock);

        // Act
        $expenseRepo = new BillingRepository($expenseMock);
        $result = $expenseRepo->getLatestByAccountUuid($uuid);

        // Assert
        $this->assertInstanceOf(Billing::class, $result);
    }

    #[Test]
    public function testUpdateProjection()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = serialize([]);

        $mock = Mockery::mock(Billing::class)->makePartial();
        $mock->shouldReceive('save')->once()->andReturnTrue();

        $this->app->instance(Billing::class, $mock);

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
        $expenseMock = $this->createMock(Billing::class);

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
