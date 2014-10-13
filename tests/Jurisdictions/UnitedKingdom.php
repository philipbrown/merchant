<?php namespace PhilipBrown\Merchant\Tests\Jurisdictions;

use Money\Currency;
use PhilipBrown\Merchant\Jurisdictions\UnitedKingdom;

class UnitedKingdomTest extends \PHPUnit_Framework_TestCase
{
    /** @var Jurisdiction */
    private $jurisdiction;

    public function setUp()
    {
        $this->jurisdiction = new UnitedKingdom;
    }

    /** @test */
    public function should_return_the_tax_rate()
    {
        $this->assertInstanceOf(
            'PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax', $this->jurisdiction->rate());
    }

    /** @test */
    public function should_return_the_currency()
    {
         $this->assertEquals(new Currency('GBP'), $this->jurisdiction->currency());
    }

    /** @test */
    public function should_return_the_locale()
    {
        $this->assertEquals('en_GB', $this->jurisdiction->locale());
    }
}
