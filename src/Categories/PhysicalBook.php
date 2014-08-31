<?php namespace PhilipBrown\Merchant\Categories;

use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Category;

class PhysicalBook implements Category
{
    /**
     * Categories a product as a physical book
     *
     * @param Product $product
     * @return void
     */
    public function categorise(Product $product)
    {
        $product->setTaxable(Status::set(false));
    }
}
