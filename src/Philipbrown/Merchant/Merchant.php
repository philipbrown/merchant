<?php namespace Philipbrown\Merchant;

use Philipbrown\Merchant\Exception\InvalidRegionException;

class Merchant {

  /**
   * Create
   *
   * @param string $region
   */
  public function create($region)
  {
    $class = 'Philipbrown\Merchant\Region\\'.ucfirst($region);

    if(class_exists($class))
    {
      return new Order(new $class);
    }

    throw new InvalidRegionException("$region is not a valid region");
  }

}
