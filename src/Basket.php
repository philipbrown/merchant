<?php namespace PhilipBrown\Merchant;

use Closure;
use Money\Money;
use League\Event\Emitter;
use PhilipBrown\Merchant\Evenys\ProductWasAddedToBasket;
use PhilipBrown\Merchant\Evenys\ProductWasUpdatedInBasket;
use PhilipBrown\Merchant\Evenys\ProductWasRemovedFromBasket;

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
     * @var Emitter
     */
    private $emitter;

    /**
     * Create a new Basket
     *
     * @param Jurisdiction $jurisdiction
     * @return void
     */
    public function __construct(Jurisdiction $jurisdiction, Emitter $emitter = null)
    {
        $this->rate       = $jurisdiction->rate();
        $this->currency   = $jurisdiction->currency();
        $this->products   = new Collection;
        $this->emitter = $emitter;
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
     * Get the Currency of the Basket
     *
     * @return Currency
     */
    public function currency()
    {
        return $this->currency;
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
     * Add a product to the basket
     *
     * @param string $sku
     * @param string $name
     * @param Money $price
     * @param Closure $action
     * @return void
     */
    public function add($sku, $name, Money $price, Closure $action = null)
    {
        $product = new Product($sku, $name, $price, $this->rate);

        if ($action) {
          $product->action($action);
        }

        $this->products->add($sku, $product);

        if ($this->emitter) {
            $this->emitter->fire(new ProductWasAddedToBasket($product, $this->products));
        }
    }

    /**
     * Update a product that is already in the basket
     *
     * @param string $sku
     * @param Closure $action
     * @return void
     */
    public function update($sku, Closure $action)
    {
        $product = $this->pick($sku);

        $product->action($action);

        if ($this->emitter) {
            $this->emitter->fire(new ProductWasUpdatedInBasket($product, $this->products));
        }
    }

    /**
     * Remove a product from the basket
     *
     * @param string $sku
     * @return void
     */
    public function remove($sku)
    {
        $product = $this->pick($sku);

        $this->products->remove($sku);

        if ($this->emitter) {
            $this->emitter->fire(new ProductWasRemovedFromBasket($product, $this->products));
        }
    }
}
