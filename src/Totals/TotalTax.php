<?php namespace PhilipBrown\Merchant\Totals;

use Money\Money;
use PhilipBrown\Merchant\Total;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Reconciler;
use PhilipBrown\Merchant\AbstractTotal;

class TotalTax extends AbstractTotal implements Total
{
    /**
     * @var Reconciler
     */
    private $reconciler;

    /**
     * Create a new TotalValue
     *
     * @param Reconciler $reconciler
     * @return void
     */
    public function __construct(Reconciler $reconciler)
    {
        $this->reconciler = $reconciler;
    }

    /**
     * Run calculation
     *
     * @param Basket $basket
     * @return Money
     */
    public function calculate(Basket $basket)
    {
        $tax = new Money(0, $basket->currency());

        foreach ($basket->products() as $product) {
            $tax = $tax->add($this->reconciler->tax($product));
        }

        return $tax;
    }
}
