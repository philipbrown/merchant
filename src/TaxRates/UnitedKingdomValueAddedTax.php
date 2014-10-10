<?php namespace PhilipBrown\Merchant\TaxRates;

use PhilipBrown\Merchant\TaxRate;

class UnitedKingdomValueAddedTax implements TaxRate
{
    /**
     * @var float
     */
    private $rate;

    /**
     * Create a new Tax Rate
     *
     * @return void
     */
    public function __construct()
    {
        $this->rate = 0.20;
    }

    /**
     * Return the Tax Rate as a float
     *
     * @return float
     */
    public function float()
    {
        return $this->rate;
    }

    /**
     * Return the Tax Rate as a percentage
     *
     * @return int
     */
    public function percentage()
    {
        return $this->rate * 100;
    }
}
