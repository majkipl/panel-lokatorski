<?php

namespace Tests\Domains\User\Domain\Models;

use App\Domains\User\Domain\Models\User;
use App\Domains\User\Infrastructure\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    #[\PHPUnit\Framework\Attributes\Test]
    public function getRedirectRouteReturnsExpectedString()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->assertEquals('admin.dashboard', $user->getRedirectRoute());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function accountReturnsExpectedRelation()
    {
        $user = User::factory()->create();

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $user->account->uuid
        );
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function newFactoryReturnsExpectedFactory()
    {
        $factory = User::newFactory();

        $this->assertInstanceOf(UserFactory::class, $factory);
    }
}
