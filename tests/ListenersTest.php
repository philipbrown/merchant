<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Collection;
use PhilipBrown\Merchant\Stubs\StubTaxRate;
use PhilipBrown\Merchant\Listeners\RemoveZeroQuantityProductsFromList;

class ListenersTest extends PHPUnit_Framework_TestCase {

  /** @var Product */
  private $product1;

  /** @var $product */
  private $product2;

  /** @var Collection */
  private $collection;

  public function setUp()
  {
    $price = new Money(100, new Currency('GBP'));

    $this->product1   = new Product('123', 'Product 1', $price, new StubTaxRate);
    $this->product2   = new Product('456', 'Product 2', $price, new StubTaxRate);
    $this->collection = new Collection([$this->product1, $this->product2]);
  }

  /** @test */
  public function listener_should_remove_zero_quantity_products()
  {
    $this->product2->decrement();

    $listener = new RemoveZeroQuantityProductsFromList;
    $listener->handle($this->product2, $this->collection);

    $this->assertEquals(1, $this->collection->count());
  }

}
