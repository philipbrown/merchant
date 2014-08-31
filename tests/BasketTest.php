<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Jurisdictions\UnitedKingdom;

class BasketTest extends PHPUnit_Framework_TestCase
{
    /** @var Basket */
    private $basket;

    public function setUp()
    {
        $this->basket = new Basket(new UnitedKingdom, new Dispatcher);
    }

    /** @test */
    public function should_get_products_count()
    {
        $this->assertEquals(0, $this->basket->count());
    }

    /** @test */
    public function should_get_the_currency()
    {
        $this->assertInstanceOf('Money\Currency', $this->basket->currency());
    }

    /** @test */
    public function should_get_the_rate()
    {
        $this->assertInstanceOf('PhilipBrown\Merchant\TaxRate', $this->basket->rate());
    }

    /** @test */
    public function should_get_the_products_collection()
    {
        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->basket->products());
    }

    /** @test */
    public function should_add_product_to_basket()
    {
        $this->assertEquals(0, $this->basket->count());

        $this->basket->add(SKU::set('123'), Name::set('iPhone'), new Money(1000, new Currency('GBP')));

        $this->assertEquals(1, $this->basket->count());

        $this->basket->add(SKU::set('456'), Name::set('MacBook'), new Money(1500, new Currency('GBP')));

        $this->assertEquals(2, $this->basket->count());
    }

  /** @test */
  public function should_pick_product_from_the_basket()
  {
      $this->basket->add(SKU::set('123'), Name::set('iPhone'), new Money(1000, new Currency('GBP')));
      $this->basket->add(SKU::set('456'), Name::set('MacBook'), new Money(1500, new Currency('GBP')));

      $product = $this->basket->pick('123');

      $this->assertInstanceOf('PhilipBrown\Merchant\Product', $product);
      $this->assertEquals('123', $product->sku());
      $this->assertEquals('iPhone', $product->name());
  }

  /** @test */
  public function should_remove_product_from_the_basket()
  {
      $this->basket->add(SKU::set('123'), Name::set('iPhone'), new Money(1000, new Currency('GBP')));
      $this->basket->add(SKU::set('456'), Name::set('MacBook'), new Money(1500, new Currency('GBP')));

      $this->basket->remove(SKU::set('456'));

      $this->assertEquals(1, $this->basket->count());
  }
}
