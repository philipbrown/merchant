<?php

use PhilipBrown\Merchant\Countries\UnitedKingdom;

class CountryTest extends PHPUnit_Framework_TestCase {

  /** @test */
  public function uk_should_return_currency_instance()
  {
    $country = new UnitedKingdom;
    $this->assertInstanceOf('Money\Currency', $country->currency());
  }

  /** @test */
  public function uk_should_return_tax_rate_instance()
  {
    $country = new UnitedKingdom;
    $this->assertInstanceOf('PhilipBrown\Merchant\TaxRate', $country->tax());
  }

}
