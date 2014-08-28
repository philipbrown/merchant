<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Stubs\StubTaxRate;
use PhilipBrown\Merchant\Discounts\ValueDiscount;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;

class DiscountTest extends PHPUnit_Framework_TestCase
{
    /** @var PhilipBrown\Merchant\Product */
    private $product;

    public function setUp()
    {
        $sku    = SKU::set('abc123');
        $name   = Name::set('iPhone');
        $price  = new Money(1000, new Currency('GBP'));
        $rate   = new StubTaxRate;
        $this->product = new Product($sku, $name, $price, $rate);
    }

    /** @test */
    public function should_get_percentage_discount()
    {
        $percent  = Percent::set(20);
        $discount = new PercentageDiscount($percent);
        $value = $discount->calculate($this->product);

        $this->assertInstanceOf('Money\Money', $value);
        $this->assertEquals(new Money(200, new Currency('GBP')), $value);
        $this->assertEquals($percent, $discount->value());
    }

    /** @test */
    public function should_get_value_discount()
    {
        $amount = new Money(200, new Currency('GBP'));
        $discount = new ValueDiscount($amount);
        $value = $discount->calculate($this->product);

        $this->assertInstanceOf('Money\Money', $value);
        $this->assertEquals(new Money(800, new Currency('GBP')), $value);
        $this->assertEquals($amount, $discount->value());
    }
}
