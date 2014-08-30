<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\ImmutableProduct;
use PhilipBrown\Merchant\Stubs\StubTaxRate;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;

class ImmutableProductTest extends PHPUnit_Framework_TestCase
{
    /** @var Product */
    private $product;

    public function setUp()
    {
        $sku            = SKU::set('abc123');
        $name           = Name::set('iPhone');
        $price          = new Money(1000, new Currency('GBP'));
        $rate           = new StubTaxRate;
        $this->product  = new Product($sku, $name, $price, $rate);
    }

    /** @test */
    public function should_create_immutable_product()
    {
        $product = new ImmutableProduct($this->product);

        $this->assertInstanceOf('PhilipBrown\Merchant\SKU', $product->sku);
        $this->assertInstanceOf('PhilipBrown\Merchant\Name', $product->name);
        $this->assertInstanceOf('Money\Money', $product->price);
        $this->assertInstanceOf('PhilipBrown\Merchant\TaxRate', $product->rate);
        $this->assertInstanceOf('Money\Money', $product->delivery);
        $this->assertInstanceOf('PhilipBrown\Merchant\Quantity', $product->quantity);
        $this->assertInstanceOf('PhilipBrown\Merchant\Status', $product->freebie);
        $this->assertInstanceOf('PhilipBrown\Merchant\Status', $product->taxable);
        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $product->coupons);
        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $product->tags);
    }

    /** @test */
    public function should_calculate_and_set_discount()
    {
        $this->product->discount(new PercentageDiscount(Percent::set(20)));
        $product = new ImmutableProduct($this->product);

        $this->assertInstanceOf('Money\Money', $product->discount);
        $this->assertEquals(new Money(200, new Currency('GBP')), $product->discount);
    }
}
