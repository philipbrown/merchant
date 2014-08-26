<?php namespace PhilipBrown\Merchant;

use Assert\Assertion;

class Quantity extends AbstractValueObject implements ValueObject
{
    /**
     * @var int
     */
    protected $value;

    /**
     * Create a new Quantity
     *
     * @param int $value
     * @return void
     */
    private function __construct($value)
    {
      Assertion::integer($value);

      $this->value = $value;
    }

    /**
     * Static method to create a new instance
     *
     * @param int $value
     * @return Quantity
     */
    public static function set($value)
    {
      return new Quantity($value);
    }

}
