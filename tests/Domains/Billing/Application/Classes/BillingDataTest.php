<?php

namespace Tests\Domains\Billing\Application\Classes;

use App\Domains\Billing\Application\Classes\BillingData;
use App\Domains\Billing\Application\Classes\YearlyData;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BillingDataTest extends TestCase
{
    #[Test]
    public function testConstructor()
    {
        $billingData = new BillingData();

        // Assert initial values
        $this->assertEquals(0, $billingData->getBalance());
        $this->assertEquals(0, $billingData->getPayment());
        $this->assertEquals(0, $billingData->getExpense());
        $this->assertEquals(0, $billingData->getArrears());
        $this->assertEquals(0, $billingData->getCumulativeBalance());
        $this->assertEquals(0, $billingData->getCumulativePayment());
        $this->assertEquals(0, $billingData->getCumulativeExpense());
        $this->assertEquals(0, $billingData->getCommonExpense());
        $this->assertIsArray($billingData->getYears());
        $this->assertCount(0, $billingData->getYears());
    }

    #[Test]
    public function testGetYear()
    {
        $billingData = new BillingData();

        // Get a year and assert it's a YearlyData instance
        $year2022 = $billingData->getYear(2022);
        $this->assertInstanceOf(YearlyData::class, $year2022);

        // Check if the year is stored in the years array
        $this->assertArrayHasKey(2022, $billingData->getYears());

        // Check if getting the same year returns the same instance
        $year2022_2 = $billingData->getYear(2022);
        $this->assertSame($year2022, $year2022_2);
    }

    #[Test]
    public function testGetYears()
    {
        $billingData = new BillingData();

        // Get the years array and assert it's empty
        $years = $billingData->getYears();
        $this->assertIsArray($years);
        $this->assertCount(0, $years);

        // Add a year and check if it's returned by getYears method
        $billingData->getYear(2022);
        $years = $billingData->getYears();
        $this->assertCount(1, $years);
        $this->assertArrayHasKey(2022, $years);
        $this->assertInstanceOf(YearlyData::class, $years[2022]);
    }

    #[Test]
    public function testAddCumulative()
    {
        $billingData = new BillingData();

        // Add some data
        $year2022 = $billingData->getYear(2022);
        $year2022->setBalance(100);
        $year2022->setPayment(50);
        $year2022->setExpense(30);
        $monthJanuary = $year2022->getMonth('January');
        $monthJanuary->setBalance(10);
        $monthJanuary->setPayment(5);
        $monthJanuary->setExpense(3);
        $monthFebruary = $year2022->getMonth('February');
        $monthFebruary->setBalance(20);
        $monthFebruary->setPayment(10);
        $monthFebruary->setExpense(7);

        // Calculate cumulative values
        $billingData->addCumulative();

        // Assert cumulative values for the year
        $this->assertEquals(30, $year2022->getCumulativeBalance());
        $this->assertEquals(15, $year2022->getCumulativePayment());
        $this->assertEquals(10, $year2022->getCumulativeExpense());

        // Assert cumulative values for January
        $this->assertEquals(10, $monthJanuary->getCumulativeBalance());
        $this->assertEquals(5, $monthJanuary->getCumulativePayment());
        $this->assertEquals(3, $monthJanuary->getCumulativeExpense());

        // Assert cumulative values for February
        $this->assertEquals(30, $monthFebruary->getCumulativeBalance());
        $this->assertEquals(15, $monthFebruary->getCumulativePayment());
        $this->assertEquals(10, $monthFebruary->getCumulativeExpense());
    }
}
