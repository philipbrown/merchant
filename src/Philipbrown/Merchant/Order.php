<?php namespace Philipbrown\Merchant;

use Philipbrown\Merchant\RegionInterface;
use Philipbrown\Merchant\Exception\InvalidOrderException;

class Order extends Helper {

  /**
   * @var RegionInterface
   */
  protected $region;

  /**
   * @var array
   */
  protected $products;

  /**
   * @var array
   */
  protected $products_cache;

  /**
   * Construct
   *
   * @param RegionInterface $region
   */
  public function __construct(RegionInterface $region)
  {
    $this->region = $region;
  }

  /**
   * Add
   *
   * @param string $sku
   * @param integer $value
   * @param Closure|array $action
   */
  public function add($sku, $value, $action = null)
  {
    $product = new Product(
      $sku,
      $value,
      $this->region->currency,
      $this->region->tax,
      $this->region->taxRate
    );

    if(!is_null($action)) $product->action($action);

    $this->products[] = $product;

    $this->products_cache[] = $sku;
  }

  /**
   * Remove
   *
   * @param string $sku
   * @return boolean
   */
  public function remove($sku)
  {
    if(in_array($sku, $this->products_cache))
    {
      $key = array_search($sku, $this->products_cache);
      unset($this->products[$key]);
      unset($this->products_cache[$key]);
      return true;
    }

    throw new InvalidOrderException("$sku was not found in the products list");
  }

  /**
   * Get Region
   *
   * @return string
   */
  protected function getRegionParameter()
  {
    return $this->region;
  }

  /**
   * Get Products
   *
   * @return array
   */
  protected function getProductsParameter()
  {
    return $this->products;
  }

}
