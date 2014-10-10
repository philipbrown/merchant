<?php namespace PhilipBrown\Merchant;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Fixtures\ProductFixture;
use PhilipBrown\Merchant\Categories\PhysicalBook;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    /** @var array */
    private $products;

    public function setUp()
    {
        $this->products = (new ProductFixture)->load();
    }

    /** @test */
    public function should_return_the_sku()
    {
        $this->assertEquals('1', $this->products[0]->sku);
    }

    /** @test */
    public function should_return_the_name()
    {
        $this->assertEquals('The 4-Hour Work Week', $this->products[0]->name);
    }

    /** @test */
    public function should_return_the_price()
    {
        $this->assertEquals(new Money(1000, new Currency('GBP')), $this->products[0]->price);
    }

    /** @test */
    public function should_return_the_rate()
    {
        $this->assertEquals(new UnitedKingdomValueAddedTax, $this->products[0]->rate);
    }

    /** @test */
    public function should_return_the_quantity()
    {
        $this->assertEquals(1, $this->products[0]->quantity);
    }

    /** @test */
    public function should_increment_the_quantity()
    {
        $this->products[0]->increment();

        $this->assertEquals(2, $this->products[0]->quantity);
    }

    /** @test */
    public function should_decrement_the_quantity()
    {
        $this->products[0]->decrement();

        $this->assertEquals(0, $this->products[0]->quantity);
    }

    /** @test */
    public function should_set_the_quantity()
    {
        $this->products[0]->quantity(5);

        $this->assertEquals(5, $this->products[0]->quantity);
    }

    /** @test */
    public function should_return_the_freebie_status()
    {
        $this->assertFalse($this->products[0]->freebie);
    }

    /** @test */
    public function should_set_the_freebie_status()
    {
        $this->products[0]->freebie(true);

        $this->assertTrue($this->products[0]->freebie);
    }

    /** @test */
    public function should_return_the_taxable_status()
    {
        $this->assertTrue($this->products[0]->taxable);
    }

    /** @test */
    public function should_set_the_taxable_status()
    {
        $this->products[0]->taxable(false);

        $this->assertFalse($this->products[0]->taxable);
    }

    /** @test */
    public function should_return_the_delivery_charge()
    {
        $this->assertInstanceOf('Money\Money', $this->products[0]->delivery);
    }

    /** @test */
    public function should_set_delivery_charge()
    {
        $delivery = new Money(100, new Currency('GBP'));

        $this->products[0]->delivery($delivery);

        $this->assertEquals($delivery, $this->products[0]->delivery);
    }

    /** @test */
    public function should_return_the_coupons_collection()
    {
        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->products[0]->coupons);
    }

    /** @test */
    public function should_add_a_coupon()
    {
        $this->products[0]->coupons('FREE99');

        $this->assertEquals(1, $this->products[0]->coupons->count());
    }

    /** @test */
    public function should_return_the_tags_collection()
    {
        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->products[0]->tags);
    }

    /** @test */
    public function should_add_a_tag()
    {
        $this->products[0]->tags('campaign_123456');

        $this->assertEquals(1, $this->products[0]->tags->count());
    }

    /** @test */
    public function should_add_discount()
    {
        $this->products[0]->discount(new PercentageDiscount(20));

        $this->assertInstanceOf(
            'PhilipBrown\Merchant\Discounts\PercentageDiscount', $this->products[0]->discount);
    }

    /** @test */
    public function should_categorise_a_product()
    {
        $this->products[0]->category(new PhysicalBook);

        $this->assertInstanceOf('PhilipBrown\Merchant\Categories\PhysicalBook', $this->products[0]->category);
        $this->assertFalse($this->products[0]->taxable);
    }

    /** @test */
    public function should_run_closure_of_actions()
    {
        $this->products[0]->action(function ($product) {
            $product->quantity(3);
            $product->freebie(true);
            $product->taxable(false);
        });

        $this->assertEquals(3, $this->products[0]->quantity);
        $this->assertTrue($this->products[0]->freebie);
        $this->assertFalse($this->products[0]->taxable);
    }
}
