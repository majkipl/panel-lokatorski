<?php

namespace App\Domains\Billing\Application\Classes;

class BaseData
{
    /**
     * @var float
     */
    public float $balance = 0;

    /**
     * @var float
     */
    public float $payment = 0;

    /**
     * @var float
     */
    public float $expense = 0;

    /**
     * @var float
     */
    public float $arrears = 0;

    /**
     * @var float
     */
    public float $cumulativeBalance = 0;

    /**
     * @var float
     */
    public float $cumulativePayment = 0;

    /**
     * @var float
     */
    public float $cumulativeExpense = 0;

    /**
     * @var float
     */
    public float $commonExpense = 0;

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     * @return void
     */
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return float
     */
    public function getPayment(): float
    {
        return $this->payment;
    }

    /**
     * @param float $payment
     * @return void
     */
    public function setPayment(float $payment): void
    {
        $this->payment = $payment;
    }

    /**
     * @return float
     */
    public function getExpense(): float
    {
        return $this->expense;
    }

    /**
     * @param float $expense
     * @return void
     */
    public function setExpense(float $expense): void
    {
        $this->expense = $expense;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function increaseBalance(float $amount): void
    {
        $this->balance += $amount;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function decreaseBalance(float $amount): void
    {
        $this->balance -= $amount;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function increasePayment(float $amount): void
    {
        $this->payment += $amount;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function decreasePayment(float $amount): void
    {
        $this->payment -= $amount;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function increaseExpense(float $amount): void
    {
        $this->expense += $amount;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function decreaseExpense(float $amount): void
    {
        $this->expense -= $amount;
    }

    /**
     * @return float
     */
    public function getCumulativePayment(): float
    {
        return $this->cumulativePayment;
    }

    /**
     * @param float $cumulativePayment
     * @return void
     */
    public function setCumulativePayment(float $cumulativePayment): void
    {
        $this->cumulativePayment = $cumulativePayment;
    }

    /**
     * @return float
     */
    public function getCumulativeExpense(): float
    {
        return $this->cumulativeExpense;
    }

    /**
     * @param float $cumulativeExpense
     * @return void
     */
    public function setCumulativeExpense(float $cumulativeExpense): void
    {
        $this->cumulativeExpense = $cumulativeExpense;
    }

    /**
     * @return float
     */
    public function getCumulativeBalance(): float
    {
        return $this->cumulativeBalance;
    }

    /**
     * @param float $cumulativeBalance
     * @return void
     */
    public function setCumulativeBalance(float $cumulativeBalance): void
    {
        $this->cumulativeBalance = $cumulativeBalance;
        $this->arrears = $this->cumulativeBalance - $this->balance;
    }

    /**
     * @return float
     */
    public function getArrears(): float
    {
        return $this->arrears;
    }

    /**
     * @param float $arrears
     * @return void
     */
    public function setArrears(float $arrears): void
    {
        $this->arrears = $arrears;
    }

    /**
     * @return float
     */
    public function getCommonExpense(): float
    {
        return $this->commonExpense;
    }

    /**
     * @param float $expense
     * @return void
     */
    public function setCommonExpense(float $expense): void
    {
        $this->commonExpense = $expense;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function increaseCommonExpense(float $amount): void
    {
        $this->commonExpense += $amount;
    }

    /**
     * @param float $amount
     * @return void
     */
    public function decreaseCommonExpense(float $amount): void
    {
        $this->commonExpense -= $amount;
    }
}
