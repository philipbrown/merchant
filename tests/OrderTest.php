<?php

use PhilipBrown\Merchant\Order;
use PhilipBrown\Merchant\Collection;

class OrderTest extends PHPUnit_Framework_TestCase {

  /** @var Order */
  private $order;

  public function setUp()
  {
    $this->order = new Order(new Collection, new Collection);
  }

  /** @test */
  public function should_get_totals_collection()
  {
    $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->order->totals());
  }

  /** @test */
  public function should_get_products_collection()
  {
    $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $this->order->products());
  }

}
