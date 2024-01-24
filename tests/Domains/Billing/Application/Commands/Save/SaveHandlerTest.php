<?php

namespace Tests\Domains\Billing\Application\Commands\Save;

use App\Domains\Billing\Application\Commands\Save\SaveCommand;
use App\Domains\Billing\Application\Commands\Save\SaveHandler;
use App\Domains\Billing\Domain\Repositories\BillingRepositoryInterface;
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

        $repositoryMock = $this->createMock(BillingRepositoryInterface::class);
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
