<?php namespace PhilipBrown\Merchant;

interface Discount {

  /**
   * Calculate the discount
   *
   * @param PhilipBrown\Merchant\Product
   * @return Money\Money
   */
  public function calculate(Product $product);

  /**
   * Return the value of the Discount
   *
   * @return mixed
   */
  public function value();

}
