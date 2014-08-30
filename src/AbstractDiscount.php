<?php namespace PhilipBrown\Merchant;

abstract class AbstractDiscount
{
    /**
     * Return the value of the discount
     *
     * @return mixed
     */
    public function value()
    {
        return $this->discount;
    }
}
