<?php

namespace Tests\Domains\User\Application\Queries\IsThereAccountByUserId;

use App\Domains\User\Application\Queries\IsThereAccountByUserId\IsThereAccountByUserIdHandler;
use App\Domains\User\Application\Queries\IsThereAccountByUserId\IsThereAccountByUserIdQuery;
use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IsThereAccountByUserIdHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $id = 1;
        $query = new IsThereAccountByUserIdQuery($id);
        $repositoryMock = Mockery::mock(AccountRepositoryInterface::class);
        $repositoryMock->shouldReceive('isExistAccountByUserId')->with($id)->andReturn(true);
        $handler = new IsThereAccountByUserIdHandler($repositoryMock);

        // Act
        $result = $handler->handle($query);

        // Assert
        $this->assertTrue($result);
    }
}
