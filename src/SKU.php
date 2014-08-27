<?php namespace PhilipBrown\Merchant;

use Assert\Assertion;

class SKU extends String implements ValueObject
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Create a new SKU
     *
     * @param string $value
     * @return void
     */
    private function __construct($value)
    {
      Assertion::string($value);

      $this->value = $value;
    }

    /**
     * Static method to create a new instance
     *
     * @param string $value
     * @return SKU
     */
    public static function set($value)
    {
      return new SKU($value);
    }
}
