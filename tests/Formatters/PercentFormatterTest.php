<?php namespace PhilipBrown\Merchant\Tests\Formatters;

use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Formatters\PercentFormatter;

class PercentFormatterTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_return_formatted_percent()
    {
        $formatter = new PercentFormatter;

        $this->assertEquals('20%', $formatter->format(new Percent(20)));
    }
}
