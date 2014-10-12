<?php namespace PhilipBrown\Merchant\Discounts;

use Money\Money;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Discount;

class ValueDiscount implements Discount
{
    /**
     * @var Money
     */
    private $rate;

    /**
     * Create a new Discount
     *
     * @param Money $rate
     * @return void
     */
    public function __construct(Money $rate)
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
        return $this->rate;
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

    /**
     * Return the description of the Discount
     *
     * @return string
     */
     public function description()
     {
        // Need to add formatting to this
        return $this->rate->getAmount().' discount';
     }
}
