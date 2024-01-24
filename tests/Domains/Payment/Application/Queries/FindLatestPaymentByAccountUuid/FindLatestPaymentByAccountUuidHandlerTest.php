<?php

namespace Tests\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid;

use App\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid\FindLatestPaymentByAccountUuidHandler;
use App\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid\FindLatestPaymentByAccountUuidQuery;
use App\Domains\Payment\Domain\Models\Payment;
use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindLatestPaymentByAccountUuidHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        $repositoryMock = $this->createMock(PaymentRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('getLatestByAccountUuid')
            ->with(
                $this->equalTo($uuid)
            )
            ->willReturn(new Payment(['projection' => $projection]));

        $handler = new FindLatestPaymentByAccountUuidHandler($repositoryMock);
        $query = new FindLatestPaymentByAccountUuidQuery($uuid);

        // Act & Assert
        $this->assertEquals($projection, $handler->handle($query));
    }
}
