<?php

namespace Tests\Domains\Billing\Application\Classes;

use App\Domains\Billing\Application\Classes\MonthlyData;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MonthlyDataTest extends TestCase
{
    #[Test]
    public function testConstructor()
    {
        $monthlyData = new MonthlyData();

        // Assert initial values
        $this->assertEquals(0, $monthlyData->getBalance());
        $this->assertEquals(0, $monthlyData->getPayment());
        $this->assertEquals(0, $monthlyData->getExpense());
        $this->assertEquals(0, $monthlyData->getArrears());
        $this->assertEquals(0, $monthlyData->getCumulativeBalance());
        $this->assertEquals(0, $monthlyData->getCumulativePayment());
        $this->assertEquals(0, $monthlyData->getCumulativeExpense());
        $this->assertEquals(0, $monthlyData->getCommonExpense());
        $this->assertEquals(0, $monthlyData->getExpensePerCapita());
    }

    #[Test]
    public function testIncreaseAndDecreaseMethods()
    {
        $monthlyData = new MonthlyData();

        // Test increaseBalance and decreaseBalance methods
        $monthlyData->increaseBalance(100);
        $this->assertEquals(100, $monthlyData->getBalance());
        $monthlyData->decreaseBalance(50);
        $this->assertEquals(50, $monthlyData->getBalance());

        // Test increasePayment and decreasePayment methods
        $monthlyData->increasePayment(50);
        $this->assertEquals(50, $monthlyData->getPayment());
        $monthlyData->decreasePayment(20);
        $this->assertEquals(30, $monthlyData->getPayment());

        // Test increaseExpense and decreaseExpense methods
        $monthlyData->increaseExpense(30);
        $this->assertEquals(30, $monthlyData->getExpense());
        $monthlyData->decreaseExpense(10);
        $this->assertEquals(20, $monthlyData->getExpense());

        // Test increaseCommonExpense and decreaseCommonExpense methods
        $monthlyData->increaseCommonExpense(20);
        $this->assertEquals(20, $monthlyData->getCommonExpense());
        $monthlyData->decreaseCommonExpense(5);
        $this->assertEquals(15, $monthlyData->getCommonExpense());

        // Test increaseExpensePerCapita and decreaseExpensePerCapita methods
        $monthlyData->increaseExpensePerCapita(10);
        $this->assertEquals(10, $monthlyData->getExpensePerCapita());
        $monthlyData->decreaseExpensePerCapita(3);
        $this->assertEquals(7, $monthlyData->getExpensePerCapita());
    }

    #[Test]
    public function testSetCumulativeBalance()
    {
        $monthlyData = new MonthlyData();

        // Set cumulative balance
        $monthlyData->setCumulativeBalance(500);

        // Assert cumulative balance and arrears
        $this->assertEquals(500, $monthlyData->getCumulativeBalance());
        $this->assertEquals(500, $monthlyData->getArrears());

        // Decrease balance and assert arrears again
        $monthlyData->decreaseBalance(300);
        $this->assertEquals(500, $monthlyData->getArrears());
    }
}
