<?php

namespace DDD;

class Money
{
    private $amount;
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
        return new self($aMoney->amount, $aMoney->currency);
    }

    public static function ofCurrency(Currency $aCurrency)
    {
        return new self(0, $aCurrency);
    }
}