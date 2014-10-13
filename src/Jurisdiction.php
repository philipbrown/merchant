<?php namespace PhilipBrown\Merchant;

interface Jurisdiction
{
    /**
     * Return the Tax Rate
     *
     * @return TaxRate
     */
    public function rate();

    /**
     * Return the currency
     *
     * @return Money\Currency
     */
    public function currency();

    /**
     * Return the locale
     *
     * @return string
     */
    public function locale();
}
