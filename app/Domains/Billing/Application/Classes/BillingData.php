<?php

namespace App\Domains\Billing\Application\Classes;

class BillingData extends BaseData
{
    /**
     * @var array
     */
    public array $years = [];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int $year
     * @return YearlyData
     */
    public function getYear(int $year): YearlyData
    {
        $this->years[$year] = $this->years[$year] ?? new YearlyData();
        return $this->years[$year];
    }

    /**
     * @return $this
     */
    public function addCumulative(): static
    {
        $cumulativeBalance = 0;
        $cumulativePayment = 0;
        $cumulativeExpense = 0;

        /** @var YearlyData $year */
        foreach ($this->years as $year) {
            /** @var MonthlyData $month */
            foreach ($year->months as $month) {
                $cumulativeBalance += $month->balance;
                $cumulativePayment += $month->payment;
                $cumulativeExpense += $month->expense;
                $month->setCumulativeBalance($cumulativeBalance);
                $month->setCumulativePayment($cumulativePayment);
                $month->setCumulativeExpense($cumulativeExpense);
            }
            $year->setCumulativeBalance($cumulativeBalance);
            $year->setCumulativePayment($cumulativePayment);
            $year->setCumulativeExpense($cumulativeExpense);
        }
        $this->setCumulativeBalance($cumulativeBalance);
        $this->setCumulativePayment($cumulativePayment);
        $this->setCumulativeExpense($cumulativeExpense);

        return $this;
    }

    /**
     * @return array
     */
    public function getYears(): array
    {
        return $this->years;
    }
}
