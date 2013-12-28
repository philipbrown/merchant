<?php namespace Philipbrown\Merchant;

use Philipbrown\Merchant\RegionInterface;

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
