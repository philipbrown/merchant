<?php namespace PhilipBrown\Merchant;

interface Listener {

  /**
   * Listen for a Basket Event
   *
   * @param Product $product
   * @param Collection $list
   * @return void
   */
  public function handle(Product $product, Collection $list);

}
