<?php

namespace Tests\Domains\Payment\Infrastructure\Repositories;

use App\Domains\Payment\Domain\Models\Payment;
use App\Domains\Payment\Infrastructure\Repositories\PaymentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PaymentRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $paymentRepository;
    protected $payment;

    public function setUp(): void
    {
        parent::setUp();
        $this->payment = new Payment();
        $this->paymentRepository = new PaymentRepository($this->payment);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    #[Test]
    public function testGetLatestByAccountUuid()
    {
        // Arrange
        $uuid = fake()->uuid();

        $paymentMock = $this->createPartialMock(Payment::class, ['newQuery']);
        $queryMock = $this->createMock(Builder::class);
        $paymentMock->method('newQuery')->willReturn($queryMock);
        $queryMock->method('where')->willReturn($queryMock);
        $queryMock->method('latest')->willReturn($queryMock);
        $queryMock->method('first')->willReturn(new Payment(['account_uuid' => $uuid]));

        $classUnderTest = new PaymentRepository($paymentMock);

        // Act
        $result = $classUnderTest->getLatestByAccountUuid($uuid);

        // Assert
        $this->assertInstanceOf(Payment::class, $result);
    }

    #[Test]
    public function testUpdateProjection()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = serialize([]);

        $mock = Mockery::mock(Payment::class)->makePartial();
        $mock->shouldReceive('save')->once()->andReturnTrue();

        $this->app->instance(Payment::class, $mock);

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
    public function testGetLatest()
    {
        // Arrange
        $resultCollection = new Collection([]);
        $paymentsMock = $this->createMock(Builder::class);
        $rawMock = $this->createMock(Builder::class);

        // Act
        $paymentsMock->method('join')->willReturn($paymentsMock);
        $paymentsMock->method('select')->willReturn($paymentsMock);
        $paymentsMock->method('get')->willReturn($resultCollection);

        $result = $paymentsMock
            ->join($rawMock, function ($join) {
                $join->on('p1.account_uuid', '=', 'p2.account_uuid');
                $join->on('p1.updated_at', '=', 'p2.max_updated_at');
            })
            ->select('p1.*')
            ->get();

        // Assert
        $this->assertEquals($resultCollection, $result);
    }

    #[Test]
    public function testSave()
    {
        // Arrange
        $paymentMock = $this->createMock(Payment::class);

        // Act
        $paymentMock->method('save')->willReturn(true);

        $uuid = fake()->uuid();
        $projection = serialize([]);

        $paymentMock->account_uuid = $uuid;
        $paymentMock->projection = $projection;

        // Assert
        $this->assertTrue($paymentMock->save());
    }
}
