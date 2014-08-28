<?php

use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Quantity;

class QuantityTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function test_set_quantity()
    {
        $quantity = Quantity::set(10);

        $this->assertInstanceOf('PhilipBrown\Merchant\Quantity', $quantity);
    }

    /** @test */
    public function should_only_accept_integer_value()
    {
        $this->setExpectedException('Assert\AssertionFailedException');

        $quantity = Quantity::set('10');
    }

    /** @test */
    public function test_get_quantity()
    {
        $quantity = Quantity::set(10);

        $this->assertEquals(10, $quantity->value());
    }

    /** @test */
    public function test_quantity_equality()
    {
        $one    = Quantity::set(10);
        $two    = Quantity::set(10);
        $three  = Quantity::set(11);
        $four   = Percent::set(10);

        $this->assertTrue($one->equals($two));
        $this->assertFalse($one->equals($three));
        $this->assertFalse($one->equals($four));
    }
}
