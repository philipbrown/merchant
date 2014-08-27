<?php namespace PhilipBrown\Merchant;

use Assert\Assertion;

class String extends AbstractValueObject implements ValueObject
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Create a new String
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
     * @return String
     */
    public static function set($value)
    {
      return new String($value);
    }

    /**
     * Convert to snake case
     *
     * @return string
     */
    public function snake()
    {
      if (ctype_lower($this->value)) {
        return $this->value;
      }

      return new String(strtolower(preg_replace('/(.)([A-Z])/', '$1_$2', $this->value)));
    }

    /**
     * Return value when cast as string
     *
     * @return string
     */
    public function __toString()
    {
      return $this->value;
    }
}
