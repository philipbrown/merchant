<?php namespace PhilipBrown\Merchant\Tests\Jurisdictions;

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
            'PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax', $this->jurisdiction->tax());

        $this->assertInstanceOf('Money\Currency', $this->jurisdiction->currency());
    }
}
