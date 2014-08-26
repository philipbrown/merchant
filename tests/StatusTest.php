<?php

use PhilipBrown\Merchant\Status;

class StatusTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function test_set_status()
    {
      $status = Status::set(true);

      $this->assertInstanceOf('PhilipBrown\Merchant\Status', $status);
    }

    /** @test */
    public function should_only_accept_boolean_value()
    {
      $this->setExpectedException('Assert\AssertionFailedException');

      $status = Status::set('true');
    }

    /** @test */
    public function test_get_status()
    {
      $status = Status::set(true);

      $this->assertEquals(true, $status->value());
    }

    /** @test */
    public function test_status_equality()
    {
      $one    = Status::set(true);
      $two    = Status::set(true);
      $three  = Status::set(false);

      $this->assertTrue($one->equals($two));
      $this->assertFalse($one->equals($three));
    }
}
