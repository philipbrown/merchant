<?php

use PhilipBrown\Merchant\Order;
use PhilipBrown\Merchant\Collection;

class OrderTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_create_order()
    {
        $order = new Order(new Collection, new Collection);

        $this->assertInstanceOf('PhilipBrown\Merchant\Order', $order);
        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $order->totals());
        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $order->products());
    }
}
