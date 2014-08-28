<?php namespace PhilipBrown\Merchant;

abstract class AbstractJurisdiction
{
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
