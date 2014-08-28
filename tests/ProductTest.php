<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\String;
use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Quantity;
use PhilipBrown\Merchant\Stubs\StubTaxRate;

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
        $this->assertEquals(1, $this->product->quantity);

        $this->product->quantity(Quantity::set(5));

        $this->assertEquals(5, $this->product->quantity);

        $this->product->increment();

        $this->assertEquals(6, $this->product->quantity);

        $this->product->decrement();

        $this->assertEquals(5, $this->product->quantity);
    }

    /** @test */
    public function should_set_freebie_status()
    {
        $this->assertFalse($this->product->freebie);

        $this->product->freebie(Status::set(true));

        $this->assertTrue($this->product->freebie);
    }

    /** @test */
    public function should_set_taxable_status()
    {
        $this->assertTrue($this->product->taxable);

        $this->product->taxable(Status::set(false));

        $this->assertFalse($this->product->taxable);
    }

    /** @test */
    public function should_add_and_remove_coupon()
    {
        $this->assertEquals(0, count($this->product->coupons));

        $this->product->addCoupon(String::set('SUMMER_SALE'));

        $this->assertEquals(1, count($this->product->coupons));

        $this->product->removeCoupon(String::set('SUMMER_SALE'));

        $this->assertEquals(0, count($this->product->coupons));
    }

    /** @test */
    public function should_add_and_remove_tag()
    {
        $this->assertEquals(0, count($this->product->tags));

        $this->product->addTag(String::set('campaign_5742726'));

        $this->assertEquals(1, count($this->product->tags));

        $this->product->removeTag(String::set('campaign_5742726'));

        $this->assertEquals(0, count($this->product->tags));
    }
}
