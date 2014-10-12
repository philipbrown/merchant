<?php namespace PhilipBrown\Merchant\Tests\Events;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Collection;
use PhilipBrown\Merchant\Events\ProductWasAddedToBasket;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class ProductWasAddedToBasketTest extends \PHPUnit_Framework_TestCase
{
    /** @var Event */
    private $event;

    public function setUp()
    {
        $sku      = '1';
        $name     = '6 x Cheestrings';
        $rate     = new UnitedKingdomValueAddedTax;
        $price    = new Money(100, new Currency('GBP'));
        $product  = new Product($sku, $name, $price, $rate);
        $products = new Collection([$product]);

        $this->event = new ProductWasAddedToBasket($product, $products);
    }

    /** @test */
    public function should_return_event_name()
    {
        $this->assertEquals('ProductWasAddedToBasket', $this->event->name());
    }

    /** @test */
    public function should_return_product()
    {
        $this->assertInstanceOf('PhilipBrown\Merchant\Product', $this->event->product());
    }

    /** @test */
    public function should_return_products_collection()
    {
        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->event->products());
    }
}
