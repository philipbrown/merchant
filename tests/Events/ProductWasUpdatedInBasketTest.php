<?php namespace PhilipBrown\Merchant\Tests\Events;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Collection;
use PhilipBrown\Merchant\Events\ProductWasUpdatedInBasket;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class ProductWasUpdatedInBasketTest extends \PHPUnit_Framework_TestCase
{
    /** @var Event */
    private $event;

    public function setUp()
    {
        $sku      = '1';
        $name     = 'Meatball Marinara Sub';
        $rate     = new UnitedKingdomValueAddedTax;
        $price    = new Money(499, new Currency('GBP'));
        $product  = new Product($sku, $name, $price, $rate);
        $products = new Collection([$product]);

        $this->event = new ProductWasUpdatedInBasket($product, $products);
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
