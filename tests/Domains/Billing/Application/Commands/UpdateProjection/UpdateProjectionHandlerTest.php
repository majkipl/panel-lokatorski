<?php

namespace Tests\Domains\Billing\Application\Commands\UpdateProjection;

use App\Domains\Billing\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Billing\Application\Commands\UpdateProjection\UpdateProjectionHandler;
use App\Domains\Billing\Domain\Repositories\BillingRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $repositoryMock = $this->createMock(BillingRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('updateProjection')
            ->with(
                $this->equalTo('example_uuid'),
                $this->equalTo('example_projection')
            )
            ->willReturn(true);

        $handler = new UpdateProjectionHandler($repositoryMock);
        $command = new UpdateProjectionCommand('example_uuid', 'example_projection');

        // Act
        $result = $handler->handle($command);

        // Assert
        $this->assertTrue($result);
    }
}
