<?php namespace PhilipBrown\Merchant;

class Order {

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

}
