<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Categories\PhysicalBook;

class CategoriesTest extends PHPUnit_Framework_TestCase {

  /** @test */
  public function should_categorise_as_physicalbook()
  {
    $product = new Product(
      '123',
      'The 4 Hour Work Week',
      new Money(1000, new Currency('GBP')),
      new StubTaxRate
    );

    $category = new PhysicalBook;
    $category->categorise($product);

    $this->assertFalse($product->taxable);
  }

}
