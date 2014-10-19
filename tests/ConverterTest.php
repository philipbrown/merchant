<?php namespace PhilipBrown\Merchant\Tests;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Converter;
use PhilipBrown\Merchant\Formatters\MoneyFormatter;
use PhilipBrown\Merchant\Formatters\PercentFormatter;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
    /** @var Coverter */
    private $converter;

    public function setUp()
    {
        $this->converter = new Converter('en_GB');
    }

    /** @test */
    public function should_convert_money()
    {
        $output = $this->converter->convert(new Money(1000, new Currency('GBP')));

        $this->assertEquals('£10.00', $output);
    }

    /** @test */
    public function should_convert_percent()
    {
        $output = $this->converter->convert(new Percent(20));

        $this->assertEquals('20%', $output);
    }
}
