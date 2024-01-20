<?php

namespace Tests\Domains\Billing\Application\Commands\UpdateProjection;

use App\Domains\Billing\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Billing\Application\Commands\UpdateProjection\UpdateProjectionHandler;
use App\Domains\Billing\Domain\Repositories\BillingRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testHandle()
    {
        // Create a mock for BillingRepositoryInterface
        $repositoryMock = $this->createMock(BillingRepositoryInterface::class);

        // Set up expectations for the updateProjection method in BillingRepositoryInterface
        $repositoryMock->expects($this->once())
            ->method('updateProjection')
            ->with(
                $this->equalTo('example_uuid'), // UUID
                $this->equalTo('example_projection') // Projection
            )
            ->willReturn(true); // Return value

        // Create UpdateProjectionHandler instance with mocked BillingRepositoryInterface
        $handler = new UpdateProjectionHandler($repositoryMock);

        // Create UpdateProjectionCommand instance
        $command = new UpdateProjectionCommand('example_uuid', 'example_projection');

        // Call handle method
        $result = $handler->handle($command);

        // Assert that the result returned by the handle method is true
        $this->assertTrue($result);
    }
}
