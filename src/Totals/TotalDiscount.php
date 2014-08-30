<?php namespace PhilipBrown\Merchant\Totals;

use Money\Money;
use PhilipBrown\Merchant\Total;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\AbstractTotal;

class TotalDiscount extends AbstractTotal implements Total
{
    /**
     * Run calculation
     *
     * @param Basket $basket
     * @return Money
     */
    public function calculate(Basket $basket)
    {
        $discount = new Money(0, $basket->currency());

        foreach ($basket->products() as $product) {
            if ($product->discount) {
                $discount = $discount->add($product->discount->calculate($product));
            }
        }

        return $discount;
    }
}
