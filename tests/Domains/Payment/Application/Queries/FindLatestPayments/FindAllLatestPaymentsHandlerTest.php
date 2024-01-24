<?php

namespace Tests\Domains\Payment\Application\Queries\FindLatestPayments;

use App\Domains\Payment\Application\Queries\FindLatestPayments\FindAllLatestPaymentsHandler;
use App\Domains\Payment\Application\Queries\FindLatestPayments\FindAllLatestPaymentsQuery;
use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FindAllLatestPaymentsHandlerTest extends TestCase
{
    #[Test]
    public function testHandle()
    {
        // Arrange
        $repositoryMock = $this->createMock(PaymentRepositoryInterface::class);
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

        $handler = new FindAllLatestPaymentsHandler($repositoryMock);
        $query = new FindAllLatestPaymentsQuery();

        // Act
        $result = $handler->handle($query);

        // Assert
        $this->assertEquals([
            ['created_at' => '2024-05-04 18:00:00', 'amount' => 250],
            ['created_at' => '2024-05-03 15:00:00', 'amount' => 200],
            ['created_at' => '2024-05-02 12:00:00', 'amount' => 150],
            ['created_at' => '2024-05-01 10:00:00', 'amount' => 100],
        ], $result);
    }
}
