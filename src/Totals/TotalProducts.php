<?php namespace PhilipBrown\Merchant\Totals;

use PhilipBrown\Merchant\Total;
use PhilipBrown\Merchant\Number;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\AbstractTotal;

class TotalProducts extends AbstractTotal implements Total
{
    /**
     * Run calculation
     *
     * @param Basket $basket
     * @return Number
     */
    public function calculate(Basket $basket)
    {
        $count = Number::set(0);

        foreach ($basket->products() as $product) {
            $count = $count->add($product->quantity());
        }

        return $count;
    }
}
