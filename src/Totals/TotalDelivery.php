<?php namespace PhilipBrown\Merchant\Totals;

use Money\Money;
use PhilipBrown\Merchant\Total;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\AbstractTotal;

class TotalDelivery extends AbstractTotal implements Total
{
    /**
     * Run calculation
     *
     * @param Basket $basket
     * @return Money
     */
    public function calculate(Basket $basket)
    {
        $delivery = new Money(0, $basket->currency());

        foreach ($basket->products() as $product) {
            $delivery = $delivery->add($product->delivery());
        }

        return $delivery;
    }
}
