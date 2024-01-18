<?php

namespace Tests\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid;

use App\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid\FindLatestPaymentByAccountUuidHandler;
use App\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid\FindLatestPaymentByAccountUuidQuery;
use App\Domains\Payment\Domain\Models\Payment;
use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FindLatestPaymentByAccountUuidHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        // Mock PaymentRepositoryInterface
        $repositoryMock = $this->createMock(PaymentRepositoryInterface::class);

        // Set up expectations
        $repositoryMock->expects($this->once())
            ->method('getLatestByAccountUuid')
            ->with(
                $this->equalTo($uuid)  // Example UUID
            )
            ->willReturn(new Payment(['projection' => $projection])); // Example return value

        // Create FindLatestPaymentByAccountUuidHandler instance with mocked repository
        $handler = new FindLatestPaymentByAccountUuidHandler($repositoryMock);

        // Create example query
        $query = new FindLatestPaymentByAccountUuidQuery($uuid);

        // Call handle method and assert the return value
        $this->assertEquals($projection, $handler->handle($query));
    }
}
