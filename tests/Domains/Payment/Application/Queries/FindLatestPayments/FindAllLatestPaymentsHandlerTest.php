<?php

namespace Tests\Domains\Payment\Application\Queries\FindLatestPayments;

use App\Domains\Payment\Application\Queries\FindLatestPayments\FindAllLatestPaymentsHandler;
use App\Domains\Payment\Application\Queries\FindLatestPayments\FindAllLatestPaymentsQuery;
use App\Domains\Payment\Domain\Models\Payment;
use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FindAllLatestPaymentsHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        // Mock PaymentRepositoryInterface
        $repositoryMock = $this->createMock(PaymentRepositoryInterface::class);

        // Set up expectations
        $repositoryMock->expects($this->once())
            ->method('getLatest')
            ->willReturn(new Collection([
                (object) ['projection' => serialize([
                    ['created_at' => '2024-05-01 10:00:00', 'amount' => 100],
                    ['created_at' => '2024-05-02 12:00:00', 'amount' => 150],
                ])],
                (object) ['projection' => serialize([
                    ['created_at' => '2024-05-03 15:00:00', 'amount' => 200],
                    ['created_at' => '2024-05-04 18:00:00', 'amount' => 250],
                ])]
            ]));

        // Create FindAllLatestPaymentsHandler instance with mocked repository
        $handler = new FindAllLatestPaymentsHandler($repositoryMock);

        // Create example query
        $query = new FindAllLatestPaymentsQuery();

        // Call handle method and assert the return value
        $result = $handler->handle($query);

        // Assert that the returned array contains correct payments in correct order
        $this->assertEquals([
            ['created_at' => '2024-05-04 18:00:00', 'amount' => 250],
            ['created_at' => '2024-05-03 15:00:00', 'amount' => 200],
            ['created_at' => '2024-05-02 12:00:00', 'amount' => 150],
            ['created_at' => '2024-05-01 10:00:00', 'amount' => 100],
        ], $result);
    }
}
