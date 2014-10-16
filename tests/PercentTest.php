<?php namespace PhilipBrown\Merchant\Tests;

use PhilipBrown\Merchant\Percent;

class PercentTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_return_percent_as_int()
    {
        $percent = new Percent(20);

        $this->assertEquals(20, $percent->int());
    }
}
