<?php

namespace Tests\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid;

use App\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid\FindLatestBalanceByAccountUuidHandler;
use App\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid\FindLatestBalanceByAccountUuidQuery;
use App\Domains\Balance\Domain\Models\Balance;
use App\Domains\Balance\Domain\Repositories\BalanceRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindLatestBalanceByAccountUuidHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testHandle()
    {
        // Given
        $uuid = fake()->uuid();
        $expectedProjection = fake()->word();

        $query = new FindLatestBalanceByAccountUuidQuery($uuid);

        $repository = $this->createMock(BalanceRepositoryInterface::class);
        $repository->method('getLatestByAccountUuid')->with($uuid)->willReturn(new Balance(['projection' => $expectedProjection]));

        $handler = new FindLatestBalanceByAccountUuidHandler($repository);

        // When
        $result = $handler->handle($query);

        // Then
        $this->assertSame($expectedProjection, $result);
    }
}
