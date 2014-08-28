<?php

use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;

class NameTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function test_set_name()
    {
      $name = Name::set('iPhone');

      $this->assertInstanceOf('PhilipBrown\Merchant\Name', $name);
    }

    /** @test */
    public function should_only_accept_string_value()
    {
      $this->setExpectedException('Assert\AssertionFailedException');

      $name = Name::set([]);
    }

    /** @test */
    public function test_get_value()
    {
      $name = Name::set('iPhone');

      $this->assertEquals('iPhone', $name->value());
    }

    /** @test */
    public function test_cast_to_string()
    {
      $name = Name::set('iPhone');

      $this->assertEquals('iPhone', (string) $name);
    }

    /** @test */
    public function test_sku_equality()
    {
      $one    = Name::set('iPhone');
      $two    = Name::set('iPhone');
      $three  = Name::set('Android');
      $four   = SKU::set('iPhone');

      $this->assertTrue($one->equals($two));
      $this->assertFalse($one->equals($three));
      $this->assertFalse($one->equals($four));
    }
}
