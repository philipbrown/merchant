<?php namespace PhilipBrown\Merchant;

class Reconciler
{
    /**
     * @var array
     */
    private $totals;

    /**
     * Create a new Reconciler
     *
     * @param array $totals
     * @return void
     */
    public function __construct(array $totals)
    {
        $this->totals = $totals;
    }

    /**
     * Reconcile a basket
     *
     * @param Basket $basket
     * @return Order
     */
    public function reconcile(Basket $basket)
    {
        $totals = $this->totals($basket);

        $products = $this->products($basket);

        return new Order($totals, $products);
    }

    /**
     * Create a Collection of Totals
     *
     * @param Basket $basket
     * @return Collection
     */
    public function totals(Basket $basket)
    {
        $collection = new Collection;

        foreach ($this->totals as $total) {
            $collection->add($total->name(), $total->calculate($basket));
        }

        return $collection;
    }

    /**
     * Create a Collection of ImmutableProduct instances
     *
     * @param Basket $basket
     * @return Collection
     */
    public function products(Basket $basket)
    {
        $collection = new Collection;

        foreach ($basket->products() as $product) {
            $collection->add($product->sku->value(), new ImmutableProduct($product));
        }

        return $collection;
    }
}
