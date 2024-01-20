<?php

namespace Tests\Domains\Billing\Application\Classes;

use App\Domains\Billing\Application\Classes\MonthlyData;
use App\Domains\Billing\Application\Classes\YearlyData;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class YearlyDataTest extends TestCase
{
    #[Test]
    public function testConstructor()
    {
        $yearlyData = new YearlyData();

        // Assert initial values
        $this->assertEquals(0, $yearlyData->getBalance());
        $this->assertEquals(0, $yearlyData->getPayment());
        $this->assertEquals(0, $yearlyData->getExpense());
        $this->assertEquals(0, $yearlyData->getArrears());
        $this->assertEquals(0, $yearlyData->getCumulativeBalance());
        $this->assertEquals(0, $yearlyData->getCumulativePayment());
        $this->assertEquals(0, $yearlyData->getCumulativeExpense());
        $this->assertEquals(0, $yearlyData->getCommonExpense());
        $this->assertIsArray($yearlyData->getMonths());
        $this->assertCount(0, $yearlyData->getMonths());
    }

    #[Test]
    public function testGetMonth()
    {
        $yearlyData = new YearlyData();

        // Get a month and assert it's a MonthlyData instance
        $january = $yearlyData->getMonth('January');
        $this->assertInstanceOf(MonthlyData::class, $january);

        // Check if the month is stored in the months array
        $this->assertArrayHasKey('January', $yearlyData->getMonths());

        // Check if getting the same month returns the same instance
        $january2 = $yearlyData->getMonth('January');
        $this->assertSame($january, $january2);
    }

    #[Test]
    public function testGetMonths()
    {
        $yearlyData = new YearlyData();

        // Get the months array and assert it's empty
        $months = $yearlyData->getMonths();
        $this->assertIsArray($months);
        $this->assertCount(0, $months);

        // Add a month and check if it's returned by getMonths method
        $yearlyData->getMonth('January');
        $months = $yearlyData->getMonths();
        $this->assertCount(1, $months);
        $this->assertArrayHasKey('January', $months);
        $this->assertInstanceOf(MonthlyData::class, $months['January']);
    }
}
