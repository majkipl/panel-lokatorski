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
        $exampleProjection = fake()->sentence();

        // Mock the BillingRepositoryInterface
        $repository = $this->createMock(BillingRepositoryInterface::class);

        // Mock the return value of the getLatestByAccountUuid method
        $repository->method('getLatestByAccountUuid')->willReturn(new Billing(['projection' => $exampleProjection]));

        // Create an instance of the handler with the mocked repository
        $handler = new FindLatestBillingByAccountUuidHandler($repository);

        // Create an instance of the query
        $query = new FindLatestBillingByAccountUuidQuery(fake()->uuid());

        // Call the handle method
        $result = $handler->handle($query);

        // Assert the result is correct
        $this->assertEquals($exampleProjection, $result);
    }
}
