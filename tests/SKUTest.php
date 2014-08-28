<?php

use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Quantity;

class SKUTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function test_set_sku()
    {
        $sku = SKU::set('abc123');

        $this->assertInstanceOf('PhilipBrown\Merchant\SKU', $sku);
    }

    /** @test */
    public function should_only_accept_string_value()
    {
        $this->setExpectedException('Assert\AssertionFailedException');

        $sku = SKU::set(123);
    }

    /** @test */
    public function test_get_sku()
    {
        $sku = SKU::set('abc123');

        $this->assertEquals('abc123', $sku->value());
    }

    /** @test */
    public function test_cast_to_string()
    {
        $sku = SKU::set('abc123');

        $this->assertEquals('abc123', (string) $sku);
    }

    /** @test */
    public function test_sku_equality()
    {
        $one    = SKU::set('abc123');
        $two    = SKU::set('abc123');
        $three  = SKU::set('def456');
        $four   = Quantity::set(25);

        $this->assertTrue($one->equals($two));
        $this->assertFalse($one->equals($three));
        $this->assertFalse($one->equals($four));
    }
}
