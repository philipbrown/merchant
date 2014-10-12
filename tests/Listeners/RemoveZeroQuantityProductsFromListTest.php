<?php namespace PhilipBrown\Merchant\Tests\Listeners;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Collection;
use PhilipBrown\Merchant\Events\ProductWasRemovedFromBasket;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;
use PhilipBrown\Merchant\Listeners\RemoveZeroQuantityProductsFromList;

class RemoveZeroQuantityProductsFromListTest extends \PHPUnit_Framework_TestCase
{
    /** @var Event */
    private $event;

    /** @var Listener */
    private $listener;

    /** @var Collection */
    private $products;

    public function setUp()
    {
        $sku      = '1';
        $name     = 'Zinger Tower Burger';
        $rate     = new UnitedKingdomValueAddedTax;
        $price    = new Money(599, new Currency('GBP'));
        $product  = new Product($sku, $name, $price, $rate);
        $product->quantity(0);

        $this->products = new Collection([$product]);
        $this->event    = new ProductWasRemovedFromBasket($product, $this->products);
        $this->listener = new RemoveZeroQuantityProductsFromList;
    }

    /** @test */
    public function should_remove_zero_quantity_products()
    {
        $this->assertEquals(1, $this->products->count());

        $this->listener->handle($this->event);

        $this->assertEquals(0, $this->products->count());
    }
}
