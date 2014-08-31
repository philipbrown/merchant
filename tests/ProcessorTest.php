<?php

use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Processor;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Jurisdictions\UnitedKingdom;

class ProcessorTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_create_a_new_order()
    {
        $processor = new Processor([]);
        $order = $processor->process(new Basket(new UnitedKingdom, new Dispatcher));

        $this->assertInstanceOf('PhilipBrown\Merchant\Order', $order);
    }
}
