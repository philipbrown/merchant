<?php namespace PhilipBrown\Merchant;

use Assert\Assertion;

class Percent {

  use Gettable;

  /**
   * @var int
   */
  private $value;

  /**
   * @param int $value
   * @return void
   */
  private function __construct($value)
  {
    Assertion::integer($value);

    $this->value = $value;
  }

  /**
   * Set the value
   *
   * @param int $value
   * @return Quantity
   */
  public static function set($value)
  {
    return new Percent($value);
  }

}