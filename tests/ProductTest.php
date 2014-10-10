<?php namespace PhilipBrown\Merchant;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    /** @var Product */
    private $product;

    /** @var Money */
    private $price;

    /** @var TaxRate */
    private $rate;

    public function setUp()
    {
        $this->rate    = new UnitedKingdomValueAddedTax;
        $this->price   = new Money(1000, new Currency('GBP'));
        $this->product = new Product('abc', 'Flux Capacitor', $this->price, $this->rate);
    }

    /** @test */
    public function should_return_the_sku()
    {
        $this->assertEquals('abc', $this->product->sku);
    }

    /** @test */
    public function should_return_the_name()
    {
        $this->assertEquals('Flux Capacitor', $this->product->name);
    }

    /** @test */
    public function should_return_the_price()
    {
        $this->assertEquals($this->price, $this->product->price);
    }

    /** @test */
    public function should_return_the_rate()
    {
        $this->assertEquals($this->rate, $this->product->rate);
    }

    /** @test */
    public function should_return_the_quantity()
    {
        $this->assertEquals(1, $this->product->quantity);
    }

    /** @test */
    public function should_increment_the_quantity()
    {
        $this->product->increment();

        $this->assertEquals(2, $this->product->quantity);
    }

    /** @test */
    public function should_decrement_the_quantity()
    {
        $this->product->decrement();

        $this->assertEquals(0, $this->product->quantity);
    }

    /** @test */
    public function should_set_the_quantity()
    {
        $this->product->quantity(5);

        $this->assertEquals(5, $this->product->quantity);
    }

    /** @test */
    public function should_return_the_freebie_status()
    {
        $this->assertFalse($this->product->freebie);
    }

    /** @test */
    public function should_set_the_freebie_status()
    {
        $this->product->freebie(true);

        $this->assertTrue($this->product->freebie);
    }

    /** @test */
    public function should_return_the_taxable_status()
    {
        $this->assertTrue($this->product->taxable);
    }

    /** @test */
    public function should_set_the_taxable_status()
    {
        $this->product->taxable(false);

        $this->assertFalse($this->product->taxable);
    }

    /** @test */
    public function should_return_the_delivery_charge()
    {
        $this->assertInstanceOf('Money\Money', $this->product->delivery);
    }

    /** @test */
    public function should_set_delivery_charge()
    {
        $delivery = new Money(100, new Currency('GBP'));

        $this->product->delivery($delivery);

        $this->assertEquals($delivery, $this->product->delivery);
    }

    /** @test */
    public function should_return_the_coupons_collection()
    {
        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->product->coupons);
    }

    /** @test */
    public function should_add_a_coupon()
    {
        $this->product->coupons('FREE99');

        $this->assertEquals(1, $this->product->coupons->count());
    }

    /** @test */
    public function should_return_the_tags_collection()
    {
        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->product->tags);
    }

    /** @test */
    public function should_add_a_tag()
    {
        $this->product->tags('campaign_123456');

        $this->assertEquals(1, $this->product->tags->count());
    }

    /** @test */
    public function should_run_closure_of_actions()
    {
        $this->product->action(function ($product) {
            $product->quantity(3);
            $product->freebie(true);
            $product->taxable(false);
        });

        $this->assertEquals(3, $this->product->quantity);
        $this->assertTrue($this->product->freebie);
        $this->assertFalse($this->product->taxable);
    }
}
