<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Totals\Total;
use PhilipBrown\Merchant\Totals\Subtotal;
use PhilipBrown\Merchant\Totals\TotalTax;
use PhilipBrown\Merchant\Totals\TotalValue;
use PhilipBrown\Merchant\Totals\TotalProducts;
use PhilipBrown\Merchant\Totals\TotalDelivery;
use PhilipBrown\Merchant\Totals\TotalDiscount;
use PhilipBrown\Merchant\Discounts\ValueDiscount;
use PhilipBrown\Merchant\Jurisdictions\UnitedKingdom;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;

class TotalsTest extends PHPUnit_Framework_TestCase
{
    /** @var PhilipBrown\Merchant\Basket */
    private $basket;

    public function setUp()
    {
        $this->basket = new Basket(new UnitedKingdom, new Dispatcher);
        $this->basket->add(SKU::set('123'), Name::set('Car'), new Money(1000, new Currency('GBP')));
        $this->basket->add(SKU::set('456'), Name::set('Boat'), new Money(2500, new Currency('GBP')));
        $this->basket->add(SKU::set('789'), Name::set('Plane'), new Money(2200, new Currency('GBP')));
        $this->basket->add(SKU::set('abc'), Name::set(''), new Money(1000, new Currency('GBP')), function ($product) {
            $product->discount(new ValueDiscount(new Money(200, new Currency('GBP'))));
            $product->delivery(new Money(100, new Currency('GBP')));
        });
    }

    /** @test */
    public function should_calculate_the_total_value()
    {
        $total = new TotalValue;
        $output = $total->calculate($this->basket);

        $this->assertInstanceOf('Money\Money', $output);
        $this->assertEquals(new Money(6700, new Currency('GBP')), $output);
        $this->assertEquals('total_value', $total->name());
    }

    /** @test */
    public function should_count_the_total_products()
    {
        $total = new TotalProducts;
        $output = $total->calculate($this->basket);

        $this->assertEquals(4, $output);
        $this->assertEquals('total_products', $total->name());
    }

    /** @test */
    public function should_calculate_the_total_discount()
    {
        $total = new TotalDiscount;
        $output = $total->calculate($this->basket);

        $this->assertEquals(new Money(200, new Currency('GBP')), $output);
        $this->assertEquals('total_discount', $total->name());
    }

    /** @test */
    public function should_calculate_the_total_tax()
    {
        $total = new TotalTax;
        $output = $total->calculate($this->basket);

        $this->assertEquals(new Money(1340, new Currency('GBP')), $output);
        $this->assertEquals('total_tax', $total->name());
    }

    /** @test */
    public function should_calculate_total_delivery()
    {
        $total = new TotalDelivery;
        $output = $total->calculate($this->basket);

        $this->assertEquals(new Money(100, new Currency('GBP')), $output);
        $this->assertEquals('total_delivery', $total->name());
    }

    /** @test */
    public function should_calculate_subtotal()
    {
        $total = new Subtotal;
        $output = $total->calculate($this->basket);

        $this->assertEquals(new Money(6500, new Currency('GBP')), $output);
        $this->assertEquals('subtotal', $total->name());
    }

    /** @test */
    public function should_calculate_total()
    {
        $total = new Total;
        $output = $total->calculate($this->basket);

        $this->assertEquals(new Money(7940, new Currency('GBP')), $output);
        $this->assertEquals('total', $total->name());
    }
}
