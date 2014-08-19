<?php namespace PhilipBrown\Merchant\Countries;

use Money\Currency;
use PhilipBrown\Merchant\Country;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class UnitedKingdom implements Country {

  /**
   * @var Money\Currency
   */
  private $currency;

  /**
   * @var PhilipBrown\Merchant\TaxRate
   */
  private $tax;

  /**
   * Create a new Country instance
   *
   * @return void
   */
  public function __construct()
  {
    $this->tax      = new UnitedKingdomValueAddedTax;
    $this->currency = new Currency('GBP');
  }

  /**
   * Return the currency
   *
   * @return Money\Currency
   */
  public function currency()
  {
    return $this->currency;
  }

  /**
   * Return the Tax Rate
   *
   * @return PhilipBrown\Merchant\TaxRate
   */
  public function tax()
  {
    return $this->tax;
  }

}
