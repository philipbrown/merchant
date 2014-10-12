<?php namespace PhilipBrown\Merchant\Tests;

use PhilipBrown\Merchant\Order;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_have_gettable_totals_and_products_arrays()
    {
        $totals   = ['products' => 1];
        $products = [['sku' => '1']];
        $order    = new Order($totals, $products);

        $this->assertEquals($totals,   $order->totals);
        $this->assertEquals($products, $order->products);
    }
}
