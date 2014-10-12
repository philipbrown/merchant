<?php namespace PhilipBrown\Merchant\Calculators;

use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Calculator;

class TaxableCalculator implements Calculator
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
            if ($product->taxable) {
                $total = $total + $product->quantity;
            }
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
        return 'taxable';
    }
}
