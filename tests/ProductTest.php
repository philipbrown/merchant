<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Stubs\StubTaxRate;

class ProductTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_create_new_product()
    {
        $sku      = SKU::set('abc123');
        $name     = Name::set('iPhone');
        $price    = new Money(100, new Currency('GBP'));
        $rate     = new StubTaxRate;
        $product  = new Product($sku, $name, $price, $rate);

        $this->assertInstanceOf('PhilipBrown\Merchant\Product', $product);
    }
}
