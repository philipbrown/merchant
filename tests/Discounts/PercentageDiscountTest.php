<?php namespace PhilipBrown\Merchant\Tests\Discounts;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Fixtures\ProductFixture;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;

class PercentageDiscountTest extends \PHPUnit_Framework_TestCase
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
        $discount = new PercentageDiscount(20);
        $value    = $discount->calculate($this->products[0]);

        $this->assertInstanceOf('Money\Money', $value);
        $this->assertEquals(new Money(200, new Currency('GBP')), $value);
        $this->assertEquals(20, $discount->rate());
    }
}
