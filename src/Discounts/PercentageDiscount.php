<?php namespace PhilipBrown\Merchant\Discounts;

use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Discount;
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\AbstractDiscount;

class PercentageDiscount extends AbstractDiscount implements Discount {

  /**
   * @var Percent
   */
  protected $discount;

  /**
   * Create a new PercentageDiscount
   *
   * @param Percent $discount
   * @return void
   */
  public function __construct(Percent $discount)
  {
    $this->discount = $discount;
  }

  /**
   * Calculate the discount
   *
   * @param Product
   * @return Money\Money
   */
  public function calculate(Product $product)
  {
    return $product->price->multiply($this->discount->value / 100);
  }

}
