<?php namespace PhilipBrown\Merchant;

use Closure;
use Money\Money;

class Basket {

  /**
   * @var TaxRate
   */
  private $tax;

  /**
   * @var Money\Currency
   */
  private $currency;

  /**
   * @var Collection
   */
  private $products;

  /**
   * @var Dispatcher
   */
  private $dispatcher;

  /**
   * Create a new Basket
   *
   * @param Country $country
   * @param Dispatcher $dispatcher
   * @return void
   */
  public function __construct(Country $country, Dispatcher $dispatcher)
  {
    $this->tax        = $country->tax();
    $this->currency   = $country->currency();
    $this->dispatcher = $dispatcher;
    $this->products   = new Collection;
  }

  /**
   * Add a product to the basket
   *
   * @param string $sku
   * @param string $name
   * @param Money $price
   * @param Closure $action
   * @return void
   */
  public function add($sku, $name, Money $price, Closure $action = null)
  {
    $product = new Product($sku, $name, $price, $this->tax);

    if($action) $product->action($action);

    $this->products->add($sku, $product);

    $this->dispatcher->fire('product.added', [$product, $this->products]);
  }

  /**
   * Count the items in the basket
   *
   * @return int
   */
  public function count()
  {
    return $this->products->count();
  }

  /**
   * Pick a product from the basket
   *
   * @param string $sku
   * @return Product
   */
  public function pick($sku)
  {
    return $this->products->get($sku);
  }

  /**
   * Remove a product from the basket
   *
   * @param string $sku
   * @return void
   */
  public function remove($sku)
  {
    $product = $this->products->get($sku);

    $this->products->remove($sku);

    $this->dispatcher->fire('product.removed', [$product, $this->products]);
  }

}
