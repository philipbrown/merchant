<?php namespace PhilipBrown\Merchant;

interface Formatter
{
    /**
     * Format an input to an output
     *
     * @return mixed
     */
    public function format();
}
