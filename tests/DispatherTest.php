<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Collection;

class DispatcherTest extends PHPUnit_Framework_TestCase {

  /** @var PhilipBrown\Merchant\Dispatcher */
  private $dispatcher;

  public function setUp()
  {
    $this->dispatcher = new Dispatcher;
  }

  /** @test */
  public function listener_should_be_triggered_on_event()
  {
    $listener   = new StubListener;
    $product    = new Product('123', 'iPhone', new Money(100, new Currency('GBP')), new StubTaxRate);
    $collection = new Collection;
    $collection->push($product);

    $this->dispatcher->listen('event.fired', $listener);
    $this->dispatcher->fire('event.fired', [$product, $collection]);

    $this->assertEquals($product->name, $listener->product->name);
  }

}
