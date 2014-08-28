<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Quantity;
use PhilipBrown\Merchant\Stubs\StubTaxRate;
use PhilipBrown\Merchant\Categories\PhysicalBook;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class ProductTest extends PHPUnit_Framework_TestCase {

  /** @var Product */
  private $product;

  public function setUp()
  {
    $sku    = '123';
    $name   = 'iPhone';
    $price  = new Money(60000, new Currency('GBP'));
    $rate   = new StubTaxRate;
    $this->product = new Product($sku, $name, $price, $rate);
  }

  /** @test */
  public function should_get_values()
  {
    $this->assertEquals('123', $this->product->sku);
    $this->assertEquals('iPhone', $this->product->name);
    $this->assertEquals(new Money(60000, new Currency('GBP')), $this->product->price);
    $this->assertEquals(new StubTaxRate, $this->product->rate);
    $this->assertEquals(1, $this->product->quantity);
    $this->assertFalse($this->product->freebie);
    $this->assertTrue($this->product->taxable);
    $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->product->coupons);
    $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->product->tags);
  }

  /** @test */
  public function should_set_the_quantity()
  {
    $this->product->quantity(Quantity::set(10));

    $this->assertEquals(10, $this->product->quantity);
  }

  /** @test */
  public function should_only_accept_instance_of_quantity()
  {
    $this->setExpectedException('Exception');

    $this->product->quantity(-1);
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

  /** @test */
  public function should_add_coupon()
  {
    $this->assertEquals(0, $this->product->coupons->count());

    $this->product->coupon('SUMMERSALE2014');

    $this->assertEquals(1, $this->product->coupons->count());
  }

  /** @test */
  public function should_add_tag()
  {
    $this->assertEquals(0, $this->product->tags->count());

    $this->product->tag('digital');

    $this->assertEquals(1, $this->product->tags->count());
  }

  /** @test */
  public function should_set_tax_rate()
  {
    $this->product->rate(new UnitedKingdomValueAddedTax);

    $this->assertEquals(20, $this->product->rate->asPercentage());
  }

  /** @test */
  public function should_set_discount()
  {
    $this->product->discount(new PercentageDiscount(Percent::set(20)));

    $this->assertInstanceOf('PhilipBrown\Merchant\Discount', $this->product->discount);
  }

  /** @test */
  public function discount_method_should_only_accept_instances_of_discount()
  {
    $this->setExpectedException('Exception');

    $this->product->discount('20%');
  }

  /** @test */
  public function should_set_category()
  {
    $this->product->category(new PhysicalBook);

    $this->assertInstanceOf('PhilipBrown\Merchant\Category', $this->product->category);
  }

  /** @test */
  public function category_method_should_only_accept_instances_of_category()
  {
    $this->setExpectedException('Exception');

    $this->product->category('PhysicalBook');
  }

  /** @test */
  public function should_run_a_macro_of_actions()
  {
    $this->product->action(function($product)
    {
      $product->quantity(Quantity::set(3));
      $product->freebie(Status::set(true));
      $product->taxable(Status::set(false));
    });

    $this->assertEquals(3, $this->product->quantity);
    $this->assertTrue($this->product->freebie);
    $this->assertFalse($this->product->taxable);
  }

}
