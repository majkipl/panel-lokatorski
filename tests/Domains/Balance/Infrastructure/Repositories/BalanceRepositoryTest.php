<?php

namespace Tests\Domains\Balance\Infrastructure\Repositories;

use App\Domains\Balance\Domain\Models\Balance;
use App\Domains\Balance\Infrastructure\Repositories\BalanceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BalanceRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $balanceRepository;
    protected $balance;

    public function setUp(): void
    {
        parent::setUp();
        $this->balance = new Balance();
        $this->balanceRepository = new BalanceRepository($this->balance);
    }

    #[Test]
    public function testGetLatestByAccountUuid()
    {
        $uuid = fake()->uuid();
        $balance = new Balance([
            'account_uuid' => $uuid,
            'projection' => serialize([])
        ]);
        $balance->save();

        $result = $this->balanceRepository->getLatestByAccountUuid($uuid);

        $this->assertEquals($balance->id, $result->id);
    }

    #[Test]
    public function testUpdateProjection()
    {
        $uuid = fake()->uuid();
        $projection = serialize(['1234' => '4321']);

        $balance = new Balance([
            'account_uuid' => $uuid,
            'projection' => serialize([])
        ]);
        $balance->save();

        $result = $this->balanceRepository->updateProjection($uuid, $projection);

        $this->assertTrue($result);
        $this->assertDatabaseHas('balances', ['projection' => $projection]);
    }

    #[Test]
    public function testSave()
    {
        $uuid = fake()->uuid();
        $projection = serialize([]);
        $result = $this->balanceRepository->save($uuid, $projection);

        $this->assertTrue($result);
        $this->assertDatabaseHas('balances', ['account_uuid' => $uuid, 'projection' => $projection]);
    }
}
