<?php

namespace Tests\Domains\Payment\Application\Commands\UpdateProjection;

use App\Domains\Payment\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Payment\Application\Commands\UpdateProjection\UpdateProjectionHandler;
use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        $repositoryMock = $this->createMock(PaymentRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('updateProjection')
            ->with(
                $this->equalTo($uuid),
                $this->equalTo($projection)
            )
            ->willReturn(true);

        $handler = new UpdateProjectionHandler($repositoryMock);
        $command = new UpdateProjectionCommand($uuid, $projection);

        // Act
        $result = $handler->handle($command);

        // Assert
        $this->assertTrue($result);
    }
}
