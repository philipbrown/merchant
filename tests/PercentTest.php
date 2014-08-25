<?php

use PhilipBrown\Merchant\Percent;

class PercentTest extends PHPUnit_Framework_TestCase {

  /** @test */
  public function test_set_percent()
  {
    $percent = Percent::set(10);

    $this->assertInstanceOf('PhilipBrown\Merchant\Percent', $percent);
  }

  /** @test */
  public function test_get_percent()
  {
    $percent = Percent::set(10);

    $this->assertEquals(10, $percent->value);
  }

  /** @test */
  public function should_only_integers()
  {
    $this->setExpectedException('Assert\AssertionFailedException');

    $percent = Percent::set('10%');
  }

}
