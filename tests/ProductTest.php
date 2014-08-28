<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
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

}
