<?php namespace PhilipBrown\Merchant\Calculators;

use Money\Money;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Reconciler;
use PhilipBrown\Merchant\Calculator;

class TotalValue implements Calculator
{
    /**
     * @var Reconciler
     */
    private $reconciler;

    /**
     * Create a new TotalValue Calculator
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
            $total = $total->add($this->reconciler->value($product));
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
        return 'total_value';
    }
}
