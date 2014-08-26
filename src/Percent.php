<?php namespace PhilipBrown\Merchant;

use Assert\Assertion;

class Percent extends AbstractValueObject implements ValueObject
{
    /**
     * @var int
     */
    protected $value;

    /**
     * Create a new Percent
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
     * @param bool $value
     * @return Percent
     */
    public static function set($value)
    {
      return new Percent($value);
    }
}
