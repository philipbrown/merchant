<?php namespace PhilipBrown\Merchant;

interface Reconciler
{
    /**
     * Return the value of the Product
     *
     * @return Money
     */
    public function value(Product $product);

    /**
     * Return the tax of the Product
     *
     * @return Money
     */
    public function tax(Product $product);

    /**
     * Return the subtotal of the Product
     *
     * @return Money
     */
    public function subtotal(Product $product);

    /**
     * Return the total of the Product
     *
     * @return Money
     */
    public function total(Product $product);
}
