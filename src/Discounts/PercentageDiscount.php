<?php namespace PhilipBrown\Merchant\Discounts;

use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Discount;

class PercentageDiscount implements Discount {

  /**
   * @var int
   */
  private $percentage;

  /**
   * Create a new PercentageDiscount instance
   *
   * @param int $percentage
   * @return void
   */
  public function __construct($percentage)
  {
    $this->percentage = $percentage;
  }

  /**
   * Calculate the discount
   *
   * @param Product
   * @return Money\Money
   */
  public function calculate(Product $product)
  {
    return $product->price->multiply($this->percentage / 100);
  }

}
