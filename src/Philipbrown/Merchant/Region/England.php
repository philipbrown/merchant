<?php namespace Philipbrown\Merchant\Region;

use Philipbrown\Merchant\AbstractRegion;
use Philipbrown\Merchant\RegionInterface;

class England extends AbstractRegion implements RegionInterface {

  /**
   * @var string
   */
  protected $name = 'England';

  /**
   * @var string
   */
  protected $currency = 'GBP';

}
