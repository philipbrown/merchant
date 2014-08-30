<?php namespace PhilipBrown\Merchant\Totals;

use Money\Money;
use PhilipBrown\Merchant\Total;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\AbstractTotal;

class Subtotal extends AbstractTotal implements Total
{
    /**
     * Run calculation
     *
     * @param Basket $basket
     * @return Money
     */
    public function calculate(Basket $basket)
    {
        $subtotal = new Money(0, $basket->currency());

        foreach ($basket->products() as $product) {
            $subtotal = $subtotal->add($product->price);

            if($product->discount) {
                $subtotal = $subtotal->subtract($product->discount->calculate($product));
            }
        }

        return $subtotal;
    }
}
