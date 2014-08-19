<?php namespace PhilipBrown\Merchant\TaxRates;

use PhilipBrown\Merchant\TaxRate;

class UnitedKingdomValueAddedTax implements TaxRate {

  /**
   * @var float
   */
  private $rate;

  /**
   * Create a new TaxRate instance
   *
   * @return void
   */
  public function __construct()
  {
    $this->rate = 0.20;
  }

  /**
   * Return the rate as an integer
   *
   * @return int
   */
  public function asFloat()
  {
    return $this->rate;
  }

  /**
   * Return the rate as a percentage
   *
   * @return float
   */
  public function asPercentage()
  {
    return $this->rate * 100;
  }

}