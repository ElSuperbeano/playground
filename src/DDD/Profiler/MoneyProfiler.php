<?php
namespace DDD\Profiler;

use DDD\Currency;
use DDD\Money;

class MoneyProfiler extends Profiler
{
    protected $classes = array(
        '\DDD\MoneyDirectAccess\Money',
        '\DDD\MoneyAccessMethod\Money',
    );

    private $currency;

    public function __construct($cycles)
    {
        $this->cycles = $cycles;
        $this->currency = new Currency('EUR');
    }

    public function execute()
    {
        foreach (get_class_methods(__CLASS__) as $method) {
            if (strpos($method, 'profile') === 0) {
                foreach ($this->classes as $class) {
                    $this->$method($class);
                }
            }
        }
    }

    protected function profileConstruct($class)
    {
        $average = 0;
        for ($i = 0; $i < $this->cycles; $i++) {
            $start = microtime(true);
            /** @var Money $instance */
            $instance = new $class(100, $this->currency);
            $average = ($average + microtime(true) - $start) / 2;
        }
        $this->addMessage($class, __METHOD__, $average);
    }

    protected function profileAdd($class)
    {
        /** @var Money $instance */
        $instance = new $class(100, $this->currency);
        $average = 0;
        for ($i = 0; $i < $this->cycles; $i++) {
            $start = microtime(true);
            $instance->add($instance);
            $average = ($average + microtime(true) - $start) / 2;
        }
        $this->addMessage($class, __METHOD__, $average);
    }

    protected function profileEquals($class)
    {
        /** @var Money $instance */
        $instance = new $class(100, $this->currency);
        $average = 0;
        for ($i = 0; $i < $this->cycles; $i++) {
            $start = microtime(true);
            $instance->equals($instance);
            $average = ($average + microtime(true) - $start) / 2;
        }
        $this->addMessage($class, __METHOD__, $average);
    }
}