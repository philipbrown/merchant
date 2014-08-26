<?php namespace PhilipBrown\Merchant\TaxRates;

use PhilipBrown\Merchant\TaxRate;

class UnitedKingdomValueAddedTax implements TaxRate
{
    /**
     * @var float
     */
    private $rate;

    /**
     * Create a new TaxRate
     *
     * @return void
     */
    public function __construct()
    {
      $this->rate = 0.20;
    }

    /**
     * Return the rate as a float
     *
     * @return float
     */
    public function asFloat()
    {
      return $this->rate;
    }

    /**
     * Return the rate as a percentage
     *
     * @return int
     */
    public function asPercentage()
    {
      return $this->rate * 100;
    }
}
