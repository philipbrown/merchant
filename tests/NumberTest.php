<?php

use PhilipBrown\Merchant\Number;

class NumberTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_set_number()
    {
        $number = Number::set(1);

        $this->assertInstanceOf('PhilipBrown\Merchant\Number', $number);
    }

    /** @test */
    public function should_only_accept_integer_value()
    {
        $this->setExpectedException('Assert\AssertionFailedException');

        $number = Number::set('1');
    }

    /** @test */
    public function test_get_value()
    {
        $number = Number::set(1);

        $this->assertEquals(1, $number->value());
    }

    /** @test */
    public function test_number_equality()
    {
        $one    = Number::set(1);
        $two    = Number::set(1);
        $three  = Number::set(2);

        $this->assertTrue($one->equals($two));
        $this->assertFalse($one->equals($three));
    }

    /** @test */
    public function should_increment_value()
    {
        $number = Number::set(10);
        $bigger = $number->increment();

        $this->assertEquals(10, $number->value());
        $this->assertEquals(11, $bigger->value());
    }

    /** @test */
    public function should_decrement_value()
    {
        $number = Number::set(10);
        $smaller = $number->decrement();

        $this->assertEquals(10, $number->value());
        $this->assertEquals(9, $smaller->value());
    }
}
