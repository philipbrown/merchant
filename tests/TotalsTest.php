<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Totals\TotalValue;
use PhilipBrown\Merchant\Totals\TotalProducts;
use PhilipBrown\Merchant\Countries\UnitedKingdom;

class TotalsTest extends PHPUnit_Framework_TestCase {

  /** @var PhilipBrown\Merchant\Basket */
  private $basket;

  public function setUp()
  {
    $this->basket = new Basket(new UnitedKingdom, new Dispatcher);
    $this->basket->add('123', 'Car', new Money(1000, new Currency('GBP')));
    $this->basket->add('456', 'Boat', new Money(2500, new Currency('GBP')));
    $this->basket->add('789', 'Plane', new Money(2200, new Currency('GBP')));
  }

  /** @test */
  public function should_calculate_the_total_value()
  {
    $total = new TotalValue;

    $output = $total->calculate($this->basket);

    $this->assertInstanceOf('Money\Money', $output);
    $this->assertEquals(new Money(5700, new Currency('GBP')), $output);
    $this->assertEquals('total_value', $total->name());
  }

  /** @test */
  public function should_count_the_total_products()
  {
    $total = new TotalProducts;

    $output = $total->calculate($this->basket);

    $this->assertEquals(3, $output);
    $this->assertEquals('total_products', $total->name());
  }

}
