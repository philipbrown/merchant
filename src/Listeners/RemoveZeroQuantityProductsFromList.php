<?php namespace PhilipBrown\Merchant\Listeners;

use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Listener;
use PhilipBrown\Merchant\Collection;

class RemoveZeroQuantityProductsFromList implements Listener
{
    /**
     * Remove Products that have a quantity of 0
     *
     * @param Product $product
     * @param Collection $list
     * @return void
     */
    public function handle(Product $product, Collection $list)
    {
      foreach ($list as $key => $item) {
          if (! $item->quantity->value()) {
              $list->remove($key);
          }
      }
    }
}
