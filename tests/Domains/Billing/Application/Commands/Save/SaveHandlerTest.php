<?php

namespace Tests\Domains\Billing\Application\Commands\Save;

use App\Domains\Billing\Application\Commands\Save\SaveCommand;
use App\Domains\Billing\Application\Commands\Save\SaveHandler;
use App\Domains\Billing\Domain\Repositories\BillingRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveHandlerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function testHandle()
    {
        $uuid = fake()->uuid();
        $projection = fake()->sentence();

        // Mock BillingRepositoryInterface
        $repositoryMock = $this->createMock(BillingRepositoryInterface::class);

        // Set up expectation for save method in BillingRepositoryInterface
        $repositoryMock->expects($this->once())
            ->method('save')
            ->with(
                $this->equalTo($uuid), // UUID
                $this->equalTo($projection) // Projection
            )
            ->willReturn(true); // Simulating successful save operation

        // Create SaveHandler instance with mocked BillingRepositoryInterface
        $handler = new SaveHandler($repositoryMock);

        // Create SaveCommand instance
        $command = new SaveCommand($uuid, $projection);

        // Call handle method
        $result = $handler->handle($command);

        // Assert that the result is true, indicating successful handling
        $this->assertTrue($result);
    }
}
