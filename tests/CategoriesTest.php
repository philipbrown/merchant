<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Stubs\StubTaxRate;
use PhilipBrown\Merchant\Categories\PhysicalBook;

class CategoriesTest extends PHPUnit_Framework_TestCase {

  /** @test */
  public function should_categorise_as_physicalbook()
  {
    $sku      = '123';
    $name     = 'The 4 Hour Work Week';
    $price    = new Money(1000, new Currency('GBP'));
    $rate     = new StubTaxRate;
    $product  = new Product($sku, $name, $price, $rate);

    $category = new PhysicalBook;
    $category->categorise($product);

    $this->assertFalse($product->taxable);
  }

}
