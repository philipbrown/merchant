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
   */
  public function add($sku, $value, $action = null)
  {
    $this->products[] = new Product($sku, $value, $action);
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
