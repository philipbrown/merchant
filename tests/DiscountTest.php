<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Discounts\ValueDiscount;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;

class DiscountTests extends PHPUnit_Framework_TestCase {

  /** @var PhilipBrown\Merchant\Product */
  private $product;

  public function setUp()
  {
    $this->product = new Product(
      '123',
      'iPhone',
      new Money(1000, new Currency('GBP')),
      new StubTaxRate
    );
  }

  /** @test */
  public function should_get_percentage_discount()
  {
    $discount = new PercentageDiscount(20);

    $value = $discount->calculate($this->product);

    $this->assertInstanceOf('Money\Money', $value);
    $this->assertEquals(new Money(200, new Currency('GBP')), $value);
  }

  /** @test */
  public function should_get_value_discount()
  {
    $discount = new ValueDiscount(new Money(200, new Currency('GBP')));

    $value = $discount->calculate($this->product);

    $this->assertInstanceOf('Money\Money', $value);
    $this->assertEquals(new Money(800, new Currency('GBP')), $value);
  }

}
