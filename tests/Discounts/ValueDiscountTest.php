<?php namespace PhilipBrown\Merchant\Tests\Discounts;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Discounts\ValueDiscount;
use PhilipBrown\Merchant\Fixtures\ProductFixture;

class ValueDiscountTest extends \PHPUnit_Framework_TestCase
{
    /** @var array */
    private $products;

    public function setUp()
    {
        $this->products = (new ProductFixture)->load();
    }

    /** @test */
    public function should_get_value_discount()
    {
        $amount   = new Money(200, new Currency('GBP'));
        $discount = new ValueDiscount($amount);
        $value    = $discount->calculate($this->products[0]);

        $this->assertInstanceOf('Money\Money', $value);
        $this->assertEquals($amount, $value);
        $this->assertEquals($amount, $discount->rate());
    }
}
