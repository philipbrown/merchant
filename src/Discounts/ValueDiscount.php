<?php namespace PhilipBrown\Merchant\Discounts;

use Money\Money;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Discount;
use PhilipBrown\Merchant\AbstractDiscount;

class ValueDiscount extends AbstractDiscount implements Discount
{
    /**
     * @var Money
     */
    protected $rate;

    /**
     * Create a new ValueDiscount instance
     *
     * @param Money $discount
     * @return void
     */
    public function __construct(Money $discount)
    {
        $this->rate = $discount;
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
}
