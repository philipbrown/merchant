<?php namespace PhilipBrown\Merchant;

class Order
{
    /**
     * @var Collection
     */
    private $totals;

    /**
     * @var Collection
     */
    private $products;

    /**
     * Create a new Order
     *
     * @param Collection $totals;
     * @param Collection $products;
     * @return void
     */
    public function __construct(Collection $totals, Collection $products)
    {
        $this->totals = $totals;
        $this->products = $products;
    }

    /**
     * Get the totals of the order
     *
     * @return Collection
     */
    public function totals()
    {
        return $this->totals;
    }

    /**
     * Get the products of the order
     *
     * @return Collection
     */
    public function products()
    {
        return $this->products;
    }
}
