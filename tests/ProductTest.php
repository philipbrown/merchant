<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Status;
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

  /** @test */
  public function should_increment_and_decrement_quantity()
  {
    $this->assertEquals(1, $this->product->quantity);

    $this->product->increment();

    $this->assertEquals(2, $this->product->quantity);

    $this->product->decrement();

    $this->assertEquals(1, $this->product->quantity);
  }

  /** @test */
  public function should_set_freebie_status()
  {
    $this->assertFalse($this->product->freebie);

    $this->product->freebie(Status::set(true));

    $this->assertTrue($this->product->freebie);
  }

  /** @test */
  public function freebie_should_only_accept_status()
  {
    $this->setExpectedException('Exception');

    $this->product->freebie('true');
  }

  /** @test */
  public function should_set_taxable_status()
  {
    $this->assertTrue($this->product->taxable);

    $this->product->taxable(Status::set(false));

    $this->assertfalse($this->product->taxable);
  }

  /** @test */
  public function taxable_should_only_accept_status()
  {
    $this->setExpectedException('Exception');

    $this->product->taxable('false');
  }

}
