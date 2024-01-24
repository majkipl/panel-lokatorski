<?php

namespace Tests\Domains\Balance\Application\Commands\UpdateProjection;

use App\Domains\Balance\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Balance\Application\Commands\UpdateProjection\UpdateProjectionHandler;
use App\Domains\Balance\Domain\Repositories\BalanceRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateProjectionHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $uuid = fake()->uuid();
        $projection = fake()->word();

        $repositoryMock = $this->createMock(BalanceRepositoryInterface::class);
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
