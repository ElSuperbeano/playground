<?php

namespace DDD\MoneyAccessMethod;

use DDD\Currency;

class Money
{
    private $amount;
    /** @var Currency */
    private $currency;

    public function __construct($anAmount, Currency $aCurrency)
    {
        $this->setAmount($anAmount);
        $this->setCurrency($aCurrency);
    }

    private function setAmount($anAmount)
    {
        $this->amount = (int)$anAmount;
    }

    private function setCurrency(Currency $aCurrency)
    {
        $this->currency = $aCurrency;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function currency()
    {
        return $this->currency;
    }

    public static function fromMoney(Money $aMoney)
    {
        return new self($aMoney->amount(), $aMoney->currency());
    }

    public static function ofCurrency(Currency $aCurrency)
    {
        return new self(0, $aCurrency);
    }

    public function equals(Money $money)
    {
        return
            $money->currency()->equals($this->currency()) &&
            $money->amount() === $this->amount();
    }

    public function add(Money $money)
    {
        if (!$money->currency()->equals($this->currency())) {
            throw new \InvalidArgumentException();
        }
        return new self(
            $money->amount() + $this->amount(),
            $this->currency()
        );
    }

    /**
     * @param float $rate
     * @param Currency $currency
     *
     * @return Money
     */
    public function convertTo($rate, $currency)
    {
        return new self($this->amount() * $rate, $currency);
    }
}