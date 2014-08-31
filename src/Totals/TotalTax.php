<?php namespace PhilipBrown\Merchant\Totals;

use Money\Money;
use PhilipBrown\Merchant\Total;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\AbstractTotal;

class TotalTax extends AbstractTotal implements Total
{
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
            if ($product->taxable()) {
                $tax = $tax->add($product->tax());
            }
        }

        return $tax;
    }
}
