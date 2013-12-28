<?php namespace Philipbrown\Merchant;

use Philipbrown\Merchant\RegionInterface;

class Order {

  /**
   * @var RegionInterface
   */
  protected $region;

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
   * Get Region
   *
   * @return string
   */
  public function getRegionParameter()
  {
    return $this->region;
  }

  /**
   * __get Magic Method
   *
   * @return mixed
   */
  public function __get($param)
  {
    $method = 'get'.ucfirst($param).'Parameter';

    if(method_exists($this, $method))

    return $this->{$method}();
  }

}
