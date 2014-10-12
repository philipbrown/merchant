<?php namespace PhilipBrown\Merchant;

interface Transformer
{
    /**
     * Transform the Order
     *
     * @param Order $order
     * @return mixed
     */
    public function transform(Order $order);
}
