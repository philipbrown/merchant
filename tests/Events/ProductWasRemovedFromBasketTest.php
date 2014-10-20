<?php namespace PhilipBrown\Merchant\Tests\Events;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Collection;
use PhilipBrown\Merchant\Events\ProductWasRemovedFromBasket;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class ProductWasRemovedFromBasketTest extends \PHPUnit_Framework_TestCase
{
    /** @var Event */
    private $event;

    public function setUp()
    {
        $sku      = '1';
        $name     = 'XXXL Whopper Meal';
        $rate     = new UnitedKingdomValueAddedTax;
        $price    = new Money(699, new Currency('GBP'));
        $product  = new Product($sku, $name, $price, $rate);
        $products = new Collection([$product]);

        $this->event = new ProductWasRemovedFromBasket($product, $products);
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
