<?php

namespace Tests\Domains\Payment\Application\Commands\Save;

use App\Domains\Payment\Application\Commands\Save\SaveCommand;
use App\Domains\Payment\Application\Commands\Save\SaveHandler;
use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SaveHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function testHandle()
    {
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        // Mock PaymentRepositoryInterface
        $repositoryMock = $this->createMock(PaymentRepositoryInterface::class);

        // Set up expectations
        $repositoryMock->expects($this->once())
            ->method('save')
            ->with(
                $this->equalTo($uuid),  // Example UUID
                $this->equalTo($projection)                        // Example projection
            )
            ->willReturn(true); // Example return value

        // Create SaveHandler instance with mocked repository
        $handler = new SaveHandler($repositoryMock);

        // Create example command
        $command = new SaveCommand($uuid, $projection);

        // Call handle method and assert the return value
        $this->assertTrue($handler->handle($command));
    }
}
