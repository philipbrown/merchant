<?php

use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\String;

class StringTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function test_set_string()
    {
      $string = String::set('Hello World');

      $this->assertInstanceOf('PhilipBrown\Merchant\String', $string);
    }

    /** @test */
    public function should_only_accept_string_value()
    {
      $this->setExpectedException('Assert\AssertionFailedException');

      $string = String::set(123);
    }

    /** @test */
    public function test_get_string()
    {
      $string = String::set('Hello World');

      $this->assertEquals('Hello World', $string->value());
    }

    /** @test */
    public function test_cast_to_string()
    {
      $string = String::set('Hello World');

      $this->assertEquals('Hello World', (string) $string);
    }

    /** @test */
    public function test_sku_equality()
    {
      $one    = String::set('Hello World');
      $two    = String::set('Hello World');
      $three  = String::set('All of your base');
      $four   = SKU::set('abc123');

      $this->assertTrue($one->equals($two));
      $this->assertFalse($one->equals($three));
      $this->assertFalse($one->equals($four));
    }

    /** @test */
    public function should_convert_to_snake_case()
    {
      $string = String::set('HelloWorld');

      $this->assertEquals('hello_world', $string->snake());
    }
}
