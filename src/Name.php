<?php namespace PhilipBrown\Merchant;

use Assert\Assertion;

class Name extends String implements ValueObject
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Create a new Name
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
     * @return Name
     */
    public static function set($value)
    {
        return new Name($value);
    }
}
