<?php namespace PhilipBrown\Merchant\Totals;

use PhilipBrown\Merchant\Total as TotalInterface;
use PhilipBrown\Merchant\Number;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\AbstractTotal;

class TotalTaxableItems extends AbstractTotal implements TotalInterface
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
            if ($product->taxable()->value()) {
                $count = $count->add($product->quantity());
            }
        }

        return $count;
    }
}
