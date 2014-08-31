<?php namespace PhilipBrown\Merchant;

use Assert\Assertion;

class Number extends AbstractValueObject implements ValueObject
{
    /**
     * @var int
     */
    protected $value;

    /**
     * Create a new Number
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
     * @return Number
     */
    public static function set($value)
    {
        return new Number($value);
    }

    /**
     * Increment the value
     *
     * @return Number
     */
    public function increment()
    {
        return new Number($this->value + 1);
    }

    /**
     * Increment the value
     *
     * @return Number
     */
    public function decrement()
    {
        return new Number($this->value - 1);
    }

    /**
     * Add a Number
     *
     * @param Number $number
     * @return Number
     */
    public function add(Number $number)
    {
        return new Number($this->value + $number->value());
    }

    /**
     * Subtract a Number
     *
     * @param Number $number
     * @return Number
     */
    public function subtract(Number $number)
    {
        return new Number($this->value - $number->value());
    }

    /**
     * Multiply a Number
     *
     * @param Number $number
     * @return Number
     */
    public function multiply(Number $number)
    {
        return new Number($this->value * $number->value());
    }

    /**
     * Divide a Number
     *
     * @param Number $number
     * @return Number
     */
    public function divide(Number $number)
    {
        return new Number($this->value / $number->value());
    }
}
