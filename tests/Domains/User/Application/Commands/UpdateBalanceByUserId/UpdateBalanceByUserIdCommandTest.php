<?php

namespace Tests\Domains\User\Application\Commands\UpdateBalanceByUserId;

use App\Domains\User\Application\Commands\UpdateBalanceByUserId\UpdateBalanceByUserIdCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateBalanceByUserIdCommandTest extends TestCase
{
    #[Test]
    public function testGetIdAndBalance()
    {
        // Arrange
        $id = 1;
        $balance = 2000.0;
        $command = new UpdateBalanceByUserIdCommand($id, $balance);

        // Act
        $resultId = $command->getId();
        $resultBalance = $command->getBalance();

        // Assert
        $this->assertEquals($id, $resultId);
        $this->assertEquals($balance, $resultBalance);
    }
}
