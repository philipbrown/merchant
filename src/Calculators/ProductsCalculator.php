<?php namespace PhilipBrown\Merchant\Calculators;

use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Calculator;

class ProductsCalculator implements Calculator
{
    /**
     * Calculate the value of the Basket
     *
     * @param Basket $basket
     * @return mixed
     */
    public function calculate(Basket $basket)
    {
        $total = 0;

        foreach ($basket->products() as $product) {
            $total = $total + $product->quantity;
        }

        return $total;
    }

    /**
     * Return the name of the Calculator
     *
     * @return string
     */
    public function name()
    {
        return 'products_count';
    }
}
