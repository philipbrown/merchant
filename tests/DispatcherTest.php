<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Collection;
use PhilipBrown\Merchant\Stubs\StubTaxRate;
use PhilipBrown\Merchant\Stubs\StubListener;

class DispatcherTest extends PHPUnit_Framework_TestCase
{
    /** @var Product */
    private $product;

    /** @var Dispatcher */
    private $dispatcher;

    public function setUp()
    {
        $sku    = SKU::set('abc123');
        $name   = Name::set('iPhone');
        $price  = new Money(100, new Currency('GBP'));
        $rate   = new StubTaxRate;
        $this->product    = new Product($sku, $name, $price, $rate);
        $this->dispatcher = new Dispatcher;
    }

    /** @test */
    public function listener_should_be_triggered_on_event()
    {
        $listener   = new StubListener;
        $collection = new Collection;
        $collection->push($this->product);

        $this->dispatcher->listen('event.fired', $listener);
        $this->dispatcher->fire('event.fired', [$this->product, $collection]);

        $this->assertEquals($this->product->name, $listener->product->name);
    }
}
