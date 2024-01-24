<?php

namespace Tests\Domains\User\Application\Commands\SaveAccount;

use App\Domains\User\Application\Commands\SaveAccount\SaveAccountCommand;
use App\Domains\User\Application\Commands\SaveAccount\SaveAccountHandler;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveAccountHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $attributes = ['balance' => 1000, 'user_id' => 1];
        $command = new SaveAccountCommand($attributes);
        $repositoryMock = Mockery::mock(AccountRepositoryInterface::class);
        $repositoryMock->shouldReceive('save')->with($attributes)->andReturn(true);
        $handler = new SaveAccountHandler($repositoryMock);

        // Act
        $result = $handler->handle($command);

        // Assert
        $this->assertTrue($result);
    }
}
