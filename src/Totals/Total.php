<?php namespace PhilipBrown\Merchant\Totals;

use Money\Money;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Reconciler;
use PhilipBrown\Merchant\AbstractTotal;
use PhilipBrown\Merchant\Total as TotalInterface;

class Total extends AbstractTotal implements TotalInterface
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
            $total = $total->add($this->reconciler->total($product));
        }

        return $total;
    }
}
