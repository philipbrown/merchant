<?php namespace PhilipBrown\Merchant;

use Closure;
use Money\Money;

class Basket
{
    /**
     * @var TaxRate
     */
    private $rate;

    /**
     * @var Money\Currency
     */
    private $currency;

    /**
     * @var Collection
     */
    private $products;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * Create a new Basket
     *
     * @param Jurisdiction $jursidiction
     * @param Dispatcher $dispatcher
     * @return void
     */
    public function __construct(Jurisdiction $jursidiction, Dispatcher $dispatcher)
    {
        $this->rate       = $jursidiction->tax();
        $this->currency   = $jursidiction->currency();
        $this->dispatcher = $dispatcher;
        $this->products   = new Collection;
    }

    /**
     * Count the items in the basket
     *
     * @return int
     */
    public function count()
    {
        return $this->products->count();
    }

    /**
     * Pick a product from the basket
     *
     * @param string $sku
     * @return Product
     */
    public function pick($sku)
    {
        return $this->products->get($sku);
    }

    /**
     * Get the Currency of the Basket
     *
     * @return Currency
     */
    public function currency()
    {
        return $this->currency;
    }

    /**
     * Get the TaxRate of the Basket
     *
     * @return TaxRate
     */
    public function rate()
    {
        return $this->rate;
    }

    /**
     * Get the products from the basket
     *
     * @return Collection
     */
    public function products()
    {
        return $this->products;
    }

    /**
     * Add a product to the basket
     *
     * @param SKU $sku
     * @param Name $name
     * @param Money $price
     * @param Closure $action
     * @return void
     */
    public function add(SKU $sku, Name $name, Money $price, Closure $action = null)
    {
        $product = new Product($sku, $name, $price, $this->rate);

        if ($action) {
          $product->action($action);
        }

        $this->products->add($sku->value(), $product);

        $this->dispatcher->fire('product.added', [$product, $this->products]);
    }

    /**
     * Remove a product from the basket
     *
     * @param SKU $sku
     * @return void
     */
    public function remove(SKU $sku)
    {
        $product = $this->products->get($sku->value());

        $this->products->remove($sku->value());

        $this->dispatcher->fire('product.removed', [$product, $this->products]);
    }
}
