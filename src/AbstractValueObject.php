<?php namespace PhilipBrown\Merchant;

abstract class AbstractValueObject
{
    /**
     * Return the value of the object
     *
     * @return mixed
     */
    public function value()
    {
      return $this->value;
    }

    /**
     * Test equality with another ValueObject
     *
     * @param ValueObject $object
     * @return bool
     */
    public function equals(ValueObject $object)
    {
      return get_class($this) === get_class($object) && $this->value() === $object->value();
    }
}
