<?php namespace PhilipBrown\Merchant;

interface Calculator
{
    /**
     * Calculate the value of the Basket
     *
     * @param Basket $basket
     * @return mixed
     */
    public function calculate(Basket $basket);

    /**
     * Return the name of the Calculator
     *
     * @return string
     */
    public function name();
}
