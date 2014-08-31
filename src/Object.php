<?php namespace PhilipBrown\Merchant;

class Object
{
    /**
     * @var array
     */
    private $properties;

    /**
     * Create a new Object
     *
     * @param array $properties
     * @return void
     */
    public function __construct(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * Get the private properties of the object
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
    }
}
