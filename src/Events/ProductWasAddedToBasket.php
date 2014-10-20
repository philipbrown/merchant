<?php namespace PhilipBrown\Merchant\Events;

use League\Event\AbstractEvent;
use League\Event\EventInterface;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Collection;

class ProductWasAddedToBasket extends AbstractEvent implements EventInterface
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var Collection
     */
    private $products;

    /**
     * Create a new ProductWasAddedToBasket Event
     *
     * @param Product $product
     * @param Collection $products
     * @return void
     */
    public function __construct(Product $product, Collection $products)
    {
        $this->product  = $product;
        $this->products = $products;
    }

    /**
     * Return the Product
     *
     * @return Product
     */
    public function product()
    {
        return $this->product;
    }

    /**
     * Return the Products Collection
     *
     * @return Collection
     */
    public function products()
    {
        return $this->products;
    }

    /**
     * Return the name of the Event
     *
     * @return string
     */
    public function name()
    {
        return 'ProductWasAddedToBasket';
    }
}
