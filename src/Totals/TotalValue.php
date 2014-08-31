<?php namespace PhilipBrown\Merchant\Totals;

use Money\Money;
use PhilipBrown\Merchant\Total;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Reconciler;
use PhilipBrown\Merchant\AbstractTotal;

class TotalValue extends AbstractTotal implements Total
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
        $total = new Money(0, $basket->currency());

        foreach ($basket->products() as $product) {
          $total = $total->add($this->reconciler->value($product));
        }

        return $total;
    }
}
