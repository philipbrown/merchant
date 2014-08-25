<?php

use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Listener;
use PhilipBrown\Merchant\Collection;

class StubListener implements Listener {

  /**
   * Hand the event
   *
   * @param Product $product
   * @param Collection $list
   * @return void
   */
  public function handle(Product $product, Collection $list)
  {
    $this->product = $product;
    $this->list = $list;
  }

}
