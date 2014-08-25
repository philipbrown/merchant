<?php namespace PhilipBrown\Merchant;

use ReflectionClass;

abstract class AbstractTotal {

  /**
   * Get the name of the Total
   *
   * @return string
   */
  public function name()
  {
    $reflection = new ReflectionClass($this);

    return String::snake($reflection->getShortName());
  }

}
