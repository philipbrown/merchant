<?php namespace PhilipBrown\Merchant\TaxRates;

use PhilipBrown\Merchant\TaxRate;
use PhilipBrown\Merchant\AbstractTaxRate;

class UnitedKingdomValueAddedTax extends AbstractTaxRate implements TaxRate
{
    /**
     * @var float
     */
    protected $rate;

    /**
     * Create a new TaxRate
     *
     * @return void
     */
    public function __construct()
    {
        $this->rate = 0.20;
    }
}
