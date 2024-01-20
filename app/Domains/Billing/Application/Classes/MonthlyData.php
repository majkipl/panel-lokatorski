<?php

namespace App\Domains\Billing\Application\Classes;

class MonthlyData extends BaseData
{
    /**
     * @var float
     */
    public float $expensePerCapita = 0;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return float
     */
    public function getExpensePerCapita(): float
    {
        return $this->expensePerCapita;
    }

    /**
     * @param float $expensePerCapita
     * @return void
     */
    public function setExpensePerCapita(float $expensePerCapita): void
    {
        $this->expensePerCapita = $expensePerCapita;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function increaseExpensePerCapita(float $amount): void
    {
        $this->expensePerCapita += $amount;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function decreaseExpensePerCapita(float $amount): void
    {
        $this->expensePerCapita -= $amount;
    }
}
