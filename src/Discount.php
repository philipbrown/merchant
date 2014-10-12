<?php namespace PhilipBrown\Merchant;

interface Discount
{
    /**
     * Calculate the discount
     *
     * @param Product
     * @return Money\Money
     */
    public function calculate(Product $product);

    /**
     * Return the rate of the Discount
     *
     * @return mixed
     */
    public function rate();

    /**
     * Return the description of the Discount
     *
     * @return string
     */
    public function description();
}
