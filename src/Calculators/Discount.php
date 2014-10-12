<?php namespace PhilipBrown\Merchant\Calculators;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Calculator;
use PhilipBrown\Merchant\Reconciler;

class Discount implements Calculator
{
    /**
     * @var Reconciler
     */
    private $reconciler;

    /**
     * Create a new Discount Calculator
     *
     * @param Reconciler $reconciler
     * @return void
     */
    public function __construct(Reconciler $reconciler)
    {
        $this->reconciler = $reconciler;
    }

    /**
     * Calculate the value of the Basket
     *
     * @param Basket $basket
     * @return mixed
     */
    public function calculate(Basket $basket)
    {
        $total = new Money(0, $basket->currency());

        foreach ($basket->products() as $product) {
            $total = $total->add($this->reconciler->discount($product));
        }

        return $total;
    }

    /**
     * Return the name of the Calculator
     *
     * @return string
     */
    public function name()
    {
        return 'discount';
    }
}
