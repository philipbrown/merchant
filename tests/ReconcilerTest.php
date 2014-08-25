<?php

use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Reconciler;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Countries\UnitedKingdom;

class ReconcilerTest extends PHPUnit_Framework_TestCase {

  /** @var Basket */
  private $basket;

  public function setUp()
  {
    $this->basket = new Basket(new UnitedKingdom, new Dispatcher);
  }

  /** @test */
  public function should_create_a_new_order()
  {
    $order = (new Reconciler([]))->reconcile($this->basket);

    $this->assertInstanceOf('PhilipBrown\Merchant\Order', $order);
  }

}
