<?php namespace PhilipBrown\Merchant;

abstract class AbstractTaxRate
{
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
