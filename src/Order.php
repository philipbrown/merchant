<?php namespace PhilipBrown\Merchant;

class Order
{
    /**
     * @var array
     */
    private $totals;

    /**
     * @var array
     */
    private $products;

    /**
     * Create a new Order
     *
     * @param array $totals
     * @param array $products
     * @return void
     */
    public function __construct(array $totals, array $products)
    {
        $this->totals   = $totals;
        $this->products = $products;
    }

    /**
     * Get the private attributes
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
    }
}
