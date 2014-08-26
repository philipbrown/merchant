<?php namespace PhilipBrown\Merchant;

interface TaxRate
{
    /**
     * Return the rate as an float
     *
     * @return float
     */
    public function asFloat();

    /**
     * Return the rate as a percentage
     *
     * @return int
     */
    public function asPercentage();
}
