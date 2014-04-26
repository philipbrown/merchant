<?php namespace PhilipBrown\Merchant;

use PhilipBrown\Merchant\Exception\InvalidRegionException;

class Merchant {

  /**
   * Create
   *
   * @param string $region
   */
  public static function order($region)
  {
    $class = 'PhilipBrown\Merchant\Region\\'.ucfirst($region);

    if(class_exists($class))
    {
      return new Order(new $class);
    }

    throw new InvalidRegionException("$region is not a valid region");
  }

}
