<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class ProductTest extends PHPUnit_Framework_TestCase {

  /** @var Product */
  private $product;

  public function setUp()
  {
    $this->product = new Product(
      '123',
      'iPhone',
      new Money(60000, new Currency('GBP')),
      new UnitedKingdomValueAddedTax
    );
  }

  /** @test */
  public function should_get_values()
  {
    $this->assertEquals('123', $this->product->sku);
    $this->assertEquals('iPhone', $this->product->name);
    $this->assertEquals(new Money(60000, new Currency('GBP')), $this->product->price);
    $this->assertEquals(new UnitedKingdomValueAddedTax, $this->product->rate);
    $this->assertEquals(1, $this->product->quantity);
    $this->assertFalse($this->product->freebie);
    $this->assertTrue($this->product->taxable);
    $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->product->coupons);
    $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->product->tags);
  }

}
