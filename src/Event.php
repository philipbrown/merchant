<?php namespace PhilipBrown\Merchant;

interface Event
{
    /**
     * Return the name of the Event
     *
     * @return string
     */
    public function name();
}
