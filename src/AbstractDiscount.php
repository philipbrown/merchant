<?php namespace PhilipBrown\Merchant;

abstract class AbstractDiscount
{
    /**
     * Return the rate of the discount
     *
     * @return mixed
     */
    public function rate()
    {
        return $this->rate;
    }
}
