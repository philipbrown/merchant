<?php namespace PhilipBrown\Merchant\Discounts;

use Money\Money;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Discount;

class ValueDiscount implements Discount {

  /**
   * @var Money
   */
  private $value;

  /**
   * Create a new ValueDiscount instance
   *
   * @param Money $value
   * @return void
   */
  public function __construct(Money $value)
  {
    $this->value = $value;
  }

  /**
   * Calculate the discount
   *
   * @param Product
   * @return Money\Money
   */
  public function calculate(Product $product)
  {
    return $product->price->subtract($this->value);
  }

}
