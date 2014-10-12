<?php namespace PhilipBrown\Merchant\Tests\Formatters;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Formatters\MoneyFormatter;

class MoneyFormatterTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_format_as_english_pounds()
    {
        $formatter = new MoneyFormatter('en_GB', new Money(1000, new Currency('GBP')));

        $this->assertEquals('£10.00', $formatter->format());
    }

    /** @test */
    public function should_format_as_american_dollars()
    {
        $formatter = new MoneyFormatter('en_US', new Money(1000, new Currency('USD')));

        $this->assertEquals('$10.00', $formatter->format());
    }

    /** @test */
    public function should_format_as_european_euros()
    {
        $formatter = new MoneyFormatter('de_DE', new Money(1000, new Currency('EUR')));

        $this->assertEquals('10,00 €', $formatter->format());
    }
}
