<?php

namespace Tests\Domains\Billing\Infrastructure\Repositories;

use App\Domains\Billing\Application\Classes\BillingData;
use App\Domains\Billing\Domain\Models\Billing;
use App\Domains\Billing\Infrastructure\Repositories\BillingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BillingRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $billingRepository;
    protected $billing;

    public function setUp(): void
    {
        parent::setUp();
        $this->billing = new Billing();
        $this->billingRepository = new BillingRepository($this->billing);
    }

    #[Test]
    public function testGetLatestByAccountUuid()
    {
        $uuid = fake()->uuid();
        $billing = new Billing([
            'account_uuid' => $uuid,
            'projection' => serialize(new BillingData())
        ]);
        $billing->save();

        $result = $this->billingRepository->getLatestByAccountUuid($uuid);

        $this->assertEquals($billing->id, $result->id);
    }

    #[Test]
    public function testUpdateProjection()
    {
        $uuid = fake()->uuid();
        $billingData = new BillingData();
        $billingData->setPayment(2);
        $billingData->setExpense(1);
        $billingData->setBalance(1);
        $projection = serialize($billingData);

        $billing = new Billing([
            'account_uuid' => $uuid,
            'projection' => serialize(new BillingData())
        ]);
        $billing->save();

        $result = $this->billingRepository->updateProjection($uuid, $projection);

        $this->assertTrue($result);
        $this->assertDatabaseHas('billings', ['projection' => $projection]);
    }

    #[Test]
    public function testSave()
    {
        $uuid = fake()->uuid();
        $projection = serialize(new BillingData());
        $result = $this->billingRepository->save($uuid, $projection);

        $this->assertTrue($result);
        $this->assertDatabaseHas('billings', ['account_uuid' => $uuid, 'projection' => $projection]);
    }
}
