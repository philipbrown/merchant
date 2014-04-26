<?php namespace PhilipBrown\Merchant\Region;

use PhilipBrown\Merchant\AbstractRegion;
use PhilipBrown\Merchant\RegionInterface;

class England extends AbstractRegion implements RegionInterface {

  /**
   * @var string
   */
  protected $name = 'England';

  /**
   * @var string
   */
  protected $currency = 'GBP';

  /**
   * @var boolean
   */
  protected $tax = true;

  /**
   * @var integer
   */
  protected $taxRate = 20;

}
