<?php

namespace App\Domains\Billing\Application\Classes;

class YearlyData extends BaseData
{
    /**
     * @var array
     */
    public array $months = [];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $month
     * @return MonthlyData
     */
    public function getMonth(string $month): MonthlyData
    {
        $this->months[$month] = $this->months[$month] ?? new MonthlyData();
        return $this->months[$month];
    }

    /**
     * @return array
     */
    public function getMonths(): array
    {
        return $this->months;
    }
}
