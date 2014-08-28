<?php

use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class TaxRateTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_return_ukvat_rate_as_float()
    {
        $rate = new UnitedKingdomValueAddedTax;
        $this->assertEquals(0.20, $rate->asFloat());
    }

    /** @test */
    public function should_return_ukvat_rate_as_percentage()
    {
        $rate = new UnitedKingdomValueAddedTax;
        $this->assertEquals(20, $rate->asPercentage());
    }
}
