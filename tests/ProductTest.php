<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\String;
use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Quantity;
use PhilipBrown\Merchant\Stubs\StubTaxRate;
use PhilipBrown\Merchant\Categories\PhysicalBook;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class ProductTest extends PHPUnit_Framework_TestCase
{
    /** @var Product */
    private $product;

    public function setUp()
    {
        $sku            = SKU::set('abc123');
        $name           = Name::set('iPhone');
        $price          = new Money(100, new Currency('GBP'));
        $rate           = new StubTaxRate;
        $this->product  = new Product($sku, $name, $price, $rate);
    }

    /** @test */
    public function should_create_new_product()
    {
        $this->assertInstanceOf('PhilipBrown\Merchant\Product', $this->product);
    }

    /** @test */
    public function should_alter_the_quantity()
    {
        $this->assertEquals(1, $this->product->quantity()->value());

        $this->product->setQuantity(Quantity::set(5));

        $this->assertEquals(5, $this->product->quantity()->value());

        $this->product->increment();

        $this->assertEquals(6, $this->product->quantity()->value());

        $this->product->decrement();

        $this->assertEquals(5, $this->product->quantity()->value());
    }

    /** @test */
    public function should_set_the_delivery_cost()
    {
        $default = new Money(0, new Currency('GBP'));
        $cost = new Money(100, new Currency('GBP'));

        $this->assertEquals($default, $this->product->delivery());

        $this->product->setDelivery($cost);

        $this->assertEquals($cost, $this->product->delivery());
    }

    /** @test */
    public function should_set_freebie_status()
    {
        $this->assertFalse($this->product->freebie()->value());

        $this->product->setFreebie(Status::set(true));

        $this->assertTrue($this->product->freebie()->value());
    }

    /** @test */
    public function should_set_taxable_status()
    {
        $this->assertTrue($this->product->taxable()->value());

        $this->product->setTaxable(Status::set(false));

        $this->assertFalse($this->product->taxable()->value());
    }

    /** @test */
    public function should_add_and_remove_coupon()
    {
        $this->assertEquals(0, $this->product->coupons()->count());

        $this->product->addCoupon(String::set('SUMMER_SALE'));

        $this->assertEquals(1, $this->product->coupons()->count());

        $this->product->removeCoupon(String::set('SUMMER_SALE'));

        $this->assertEquals(0, $this->product->coupons()->count());
    }

    /** @test */
    public function should_add_and_remove_tag()
    {
        $this->assertEquals(0, $this->product->tags()->count());

        $this->product->addTag(String::set('campaign_5742726'));

        $this->assertEquals(1, $this->product->tags()->count());

        $this->product->removeTag(String::set('campaign_5742726'));

        $this->assertEquals(0, $this->product->tags()->count());
    }

    /** @test */
    public function should_set_tax_rate()
    {
        $this->assertInstanceOf('PhilipBrown\Merchant\Stubs\StubTaxRate', $this->product->rate());

        $this->product->setRate(new UnitedKingdomValueAddedTax);

        $this->assertInstanceOf('PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax', $this->product->rate());
    }

    public function should_set_discount()
    {
        $this->assertEquals(null, $this->product->discount());

        $this->product->setDiscount(new PercentageDiscount(Percent::set(50)));

        $this->assertInstanceOf('PhilipBrown\Merchant\Object', $this->product->discount());

        $this->assertEquals(new Money(20, new Currency('GBP')), $this->product->discount()->value);
        $this->assertEquals(Percent::set(50), $this->product->discount()->rate);
    }

    public function should_set_category()
    {
        $this->product->setCategory(new PhysicalBook);

        $this->assertEquals(Status::set(false), $this->product->taxable());
    }

    /** @test */
    public function should_run_a_macro_of_actions()
    {
        $this->product->action(function ($product) {
            $product->setQuantity(Quantity::set(3));
            $product->setFreebie(Status::set(true));
            $product->setTaxable(Status::set(false));
        });

        $this->assertEquals(3, $this->product->quantity()->value());
        $this->assertTrue($this->product->freebie()->value());
        $this->assertFalse($this->product->taxable()->value());
    }
}
