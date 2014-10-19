<?php namespace PhilipBrown\Merchant\Formatters;

use PhilipBrown\Merchant\Formatter;

class TaxRateFormatter implements Formatter
{
    /**
     * Format an input to an output
     *
     * @param mixed $value
     * @return mixed
     */
    public function format($value)
    {
        return $value->percentage().'%';
    }
}
