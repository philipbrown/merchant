<?php namespace PhilipBrown\Merchant\Categories;

use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Category;

class PhysicalBook implements Category {

  /**
   * Set the taxable status to false
   *
   * @param Product $product
   * @return void
   */
  public function categorise(Product $product)
  {
    $product->taxable(Status::set(false));
  }

}
