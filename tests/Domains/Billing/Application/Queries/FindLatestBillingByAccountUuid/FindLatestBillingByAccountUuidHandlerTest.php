<?php

namespace Tests\Domains\Billing\Application\Queries\FindLatestBillingByAccountUuid;

use App\Domains\Billing\Application\Queries\FindLatestBillingByAccountUuid\FindLatestBillingByAccountUuidHandler;
use App\Domains\Billing\Application\Queries\FindLatestBillingByAccountUuid\FindLatestBillingByAccountUuidQuery;
use App\Domains\Billing\Domain\Models\Billing;
use App\Domains\Billing\Domain\Repositories\BillingRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindLatestBillingByAccountUuidHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $exampleProjection = fake()->sentence();
        $repository = $this->createMock(BillingRepositoryInterface::class);
        $repository->method('getLatestByAccountUuid')->willReturn(new Billing(['projection' => $exampleProjection]));
        $handler = new FindLatestBillingByAccountUuidHandler($repository);
        $query = new FindLatestBillingByAccountUuidQuery(fake()->uuid());

        // Act
        $result = $handler->handle($query);

        // Assert
        $this->assertEquals($exampleProjection, $result);
    }
}
