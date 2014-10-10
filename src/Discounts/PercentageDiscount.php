<?php namespace PhilipBrown\Merchant\Discounts;

use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Discount;

class PercentageDiscount implements Discount
{
    /**
     * @var int
     */
    private $rate;

    /**
     * Create a new Discount
     *
     * @param int $rate
     * @return void
     */
    public function __construct($rate)
    {
        $this->rate = $rate;
    }

    /**
     * Calculate the discount
     *
     * @param Product
     * @return Money\Money
     */
    public function calculate(Product $product)
    {
        return $product->price->multiply($this->rate / 100);
    }

    /**
     * Return the rate of the Discount
     *
     * @return mixed
     */
    public function rate()
    {
        return $this->rate;
    }
}
