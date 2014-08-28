<?php

use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Quantity;

class PercentTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function test_set_percent()
    {
        $percent = Percent::set(10);

        $this->assertInstanceOf('PhilipBrown\Merchant\Percent', $percent);
    }

    /** @test */
    public function should_only_integers_value()
    {
        $this->setExpectedException('Assert\AssertionFailedException');

        $percent = Percent::set('10%');
    }

    /** @test */
    public function test_get_percent()
    {
        $percent = Percent::set(10);

        $this->assertEquals(10, $percent->value());
    }

    /** @test */
    public function test_percent_equality()
    {
        $one    = Percent::set(25);
        $two    = Percent::set(25);
        $three  = Percent::set(75);
        $four   = Quantity::set(25);

        $this->assertTrue($one->equals($two));
        $this->assertFalse($one->equals($three));
        $this->assertFalse($one->equals($four));
    }
}
