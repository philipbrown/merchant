<?php namespace PhilipBrown\Merchant\Categories;

use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Category;

class PhysicalBook implements Category
{
    /**
     * Categorise a Product
     *
     * @param Product $product
     * @return void
     */
    public function categorise(Product $product)
    {
        $product->taxable(false);
    }
}
