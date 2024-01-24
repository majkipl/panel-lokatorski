<?php

namespace Tests\Domains\User\Application\Commands\SaveAccount;

use App\Domains\User\Application\Commands\SaveAccount\SaveAccountCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveAccountCommandTest extends TestCase
{
    #[Test]
    public function testGetAttributes()
    {
        // Arrange
        $attributes = ['balance' => 1000, 'user_id' => 1];
        $command = new SaveAccountCommand($attributes);

        // Act
        $result = $command->getAttributes();

        // Assert
        $this->assertEquals($attributes, $result);
    }
}
