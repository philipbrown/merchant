<?php namespace PhilipBrown\Merchant;

class Processor {

    /**
     * @var array
     */
    private $totals;

    /**
     * Create a new Processor
     *
     * @param array $totals
     * @return void
     */
    public function __construct(array $totals)
    {
        $this->totals = $totals;
    }

    /**
     * Process a Basket and create an Order
     *
     * @param Basket $basket
     * @return Order
     */
    public function process(Basket $basket)
    {
        $totals = new Collection;

        foreach($this->totals as $total) {
            $totals->add($total->name(), $total->calculate($basket));
        }

        return new Order($totals, $basket->products());
    }
}
