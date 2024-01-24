<?php

namespace Tests\Domains\User\Application\Commands\UpdateBalanceByUserId;

use App\Domains\User\Application\Commands\UpdateBalanceByUserId\UpdateBalanceByUserIdCommand;
use App\Domains\User\Application\Commands\UpdateBalanceByUserId\UpdateBalanceByUserIdHandler;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateBalanceByUserIdHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $id = 1;
        $balance = 2000.0;
        $command = new UpdateBalanceByUserIdCommand($id, $balance);
        $repositoryMock = Mockery::mock(AccountRepositoryInterface::class);
        $repositoryMock->shouldReceive('updateBalanceByUserId')->with($id, $balance)->andReturn(true);
        $handler = new UpdateBalanceByUserIdHandler($repositoryMock);

        // Act
        $result = $handler->handle($command);

        // Assert
        $this->assertTrue($result);
    }
}
