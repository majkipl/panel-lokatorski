<?php

namespace Tests\Domains\Payment\Application\Commands\Save;

use App\Domains\Payment\Application\Commands\Save\SaveCommand;
use App\Domains\Payment\Application\Commands\Save\SaveHandler;
use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        $repositoryMock = $this->createMock(PaymentRepositoryInterface::class);
        $repositoryMock->expects($this->once())
            ->method('save')
            ->with(
                $this->equalTo($uuid),
                $this->equalTo($projection)
            )
            ->willReturn(true);

        $handler = new SaveHandler($repositoryMock);

        $command = new SaveCommand($uuid, $projection);

        // Act
        $result = $handler->handle($command);

        // Assert
        $this->assertTrue($result);
    }
}
