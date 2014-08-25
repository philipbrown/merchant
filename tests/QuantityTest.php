<?php

use PhilipBrown\Merchant\Quantity;

class QuantityTest extends PHPUnit_Framework_TestCase {

  /** @test */
  public function test_set_quantity()
  {
    $quantity = Quantity::set(10);

    $this->assertInstanceOf('PhilipBrown\Merchant\Quantity', $quantity);
  }

  /** @test */
  public function test_get_quantity()
  {
    $quantity = Quantity::set(10);

    $this->assertEquals(10, $quantity->value);
  }

  /** @test */
  public function should_only_accept_integers()
  {
    $this->setExpectedException('Assert\AssertionFailedException');

    $quantity = Quantity::set('10');
  }

}
