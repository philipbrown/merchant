<?php namespace PhilipBrown\Merchant\Stubs;

use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Listener;
use PhilipBrown\Merchant\Collection;

class StubListener implements Listener {

  /**
   * Hand the event
   *
   * @param Product $product
   * @param Collection $collection
   * @return void
   */
  public function handle(Product $product, Collection $collection)
  {
    $this->product = $product;
    $this->collection = $collection;
  }

}
