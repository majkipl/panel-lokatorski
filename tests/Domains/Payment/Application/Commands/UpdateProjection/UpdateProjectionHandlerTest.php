<?php

namespace Tests\Domains\Payment\Application\Commands\UpdateProjection;

use App\Domains\Payment\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Payment\Application\Commands\UpdateProjection\UpdateProjectionHandler;
use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateProjectionHandlerTest extends TestCase
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
            ->method('updateProjection')
            ->with(
                $this->equalTo($uuid),  // Example UUID
                $this->equalTo($projection)                        // Example projection
            )
            ->willReturn(true); // Example return value

        // Create UpdateProjectionHandler instance with mocked repository
        $handler = new UpdateProjectionHandler($repositoryMock);

        // Create example command
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Call handle method and assert the return value
        $this->assertTrue($handler->handle($command));
    }
}
