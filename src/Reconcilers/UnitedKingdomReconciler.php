<?php namespace PhilipBrown\Merchant\Reconcilers;

use Money\Money;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Reconciler;

class UnitedKingdomReconciler implements Reconciler
{
    /**
     * Return the value of the Product
     *
     * @return Money
     */
    public function value(Product $product)
    {
        return $product->price->multiply($product->quantity);
    }

    /**
     * Return the tax of the Product
     *
     * @return Money
     */
    public function tax(Product $product)
    {
        $tax = new Money(0, $product->price->getCurrency());

        if (! $product->taxable ||  $product->freebie) {
            return $tax;
        }

        $value = $this->value($product);

        if ($product->discount) {
            $value = $value->subtract($product->discount->calculate());
        }

        $value = $value->add($product->delivery);

        $tax = $value->multiply($product->rate->float());

        return $tax;
    }

    /**
     * Return the subtotal of the Product
     *
     * @return Money
     */
    public function subtotal(Product $product)
    {
        $subtotal = new Money(0, $product->price->getCurrency());

        if ($product->freebie) {
            return $subtotal;
        }

        $subtotal = $this->value($product);

        if ($product->discount) {
            $subtotal = $subtotal->subtract($product->discount->calculate());
        }

        $subtotal = $subtotal->add($product->delivery);

        return $subtotal;
    }

    /**
     * Return the total of the Product
     *
     * @return Money
     */
    public function total(Product $product)
    {
        return $this->subtotal($product)->add($this->tax($product));
    }
}
