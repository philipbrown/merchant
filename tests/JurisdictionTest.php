<?php

use PhilipBrown\Merchant\Jurisdictions\UnitedKingdom;

class JurisdictionTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function uk_should_return_currency_instance()
    {
      $jurisdication = new UnitedKingdom;
      $this->assertInstanceOf('Money\Currency', $jurisdication->currency());
    }

    /** @test */
    public function uk_should_return_tax_rate_instance()
    {
      $jurisdication = new UnitedKingdom;
      $this->assertInstanceOf('PhilipBrown\Merchant\TaxRate', $jurisdication->tax());
    }
}
