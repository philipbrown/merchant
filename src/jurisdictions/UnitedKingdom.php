<?php namespace PhilipBrown\Merchant\Jurisdictions;

use Money\Currency;
use PhilipBrown\Merchant\Jurisdiction;
use PhilipBrown\Merchant\AbstractJurisdiction;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class UnitedKingdom extends AbstractJurisdiction implements Jurisdiction
{
    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var PhilipBrown\Merchant\TaxRate
     */
    protected $tax;

    /**
     * Create a new Jurisdiction
     *
     * @return void
     */
    public function __construct()
    {
        $this->tax      = new UnitedKingdomValueAddedTax;
        $this->currency = new Currency('GBP');
    }
}
