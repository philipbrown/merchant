<?php namespace PhilipBrown\Merchant\Totals;

use Money\Money;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\AbstractTotal;
use PhilipBrown\Merchant\Total as TotalInterface;

class Total extends AbstractTotal implements TotalInterface
{
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
            $total= $total->add($product->price);

            if($product->discount) {
                $total = $total->subtract($product->discount->calculate($product));
            }

            if ($product->taxable) {
                $total = $total->add($product->price->multiply($product->rate->asPercentage() / 100));
            }

            $total = $total->add($product->delivery);
        }

        return $total;
    }
}
