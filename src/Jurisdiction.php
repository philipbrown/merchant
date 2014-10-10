<?php namespace PhilipBrown\Merchant;

interface Jurisdiction
{
    /**
     * Return the currency
     *
     * @return Money\Currency
     */
    public function currency();

    /**
     * Return the Tax Rate
     *
     * @return TaxRate
     */
    public function tax();
}
