<?php namespace PhilipBrown\Merchant;

use Assert\Assertion;

class Status extends AbstractValueObject implements ValueObject
{
    /**
     * @var bool
     */
    protected $value;

    /**
     * Create a new Status
     *
     * @param bool $value
     * @return void
     */
    private function __construct($value)
    {
        Assertion::boolean($value);

        $this->value = $value;
    }

    /**
     * Static method to create a new instance
     *
     * @param bool $value
     * @return Status
     */
    public static function set($value)
    {
        return new Status($value);
    }
}
