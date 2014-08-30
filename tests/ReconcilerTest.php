<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Reconciler;
use PhilipBrown\Merchant\Totals\TotalProducts;
use PhilipBrown\Merchant\Jurisdictions\UnitedKingdom;

class ReconcilerTest extends PHPUnit_Framework_TestCase
{
    /** @var Basket */
    private $basket;

    public function setUp()
    {
        $price = new Money(1000, new Currency('GBP'));
        $this->basket = new Basket(new UnitedKingdom, new Dispatcher);
        $this->basket->add(SKU::set('a'), Name::set('product_1'), $price);
        $this->basket->add(SKU::set('b'), Name::set('product_2'), $price);
        $this->basket->add(SKU::set('c'), Name::set('product_3'), $price);
    }

    /** @test */
    public function should_create_a_collection_of_totals()
    {
        $reconciler = new Reconciler([new TotalProducts]);

        $collection = $reconciler->totals($this->basket);

        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $collection);
        $this->assertEquals(1, $collection->count());
        $this->assertEquals(['total_products' => 3], $collection->all());
    }

    /** @test */
    public function should_create_immutable_products_collection()
    {
        $reconciler = new Reconciler([]);

        $collection = $reconciler->products($this->basket);

        $this->assertInstanceOf('PhilipBrown\Merchant\Collection', $collection);
        $this->assertEquals(3, $collection->count());

        foreach ($collection as $product) {
            $this->assertInstanceOf('PhilipBrown\Merchant\ImmutableProduct', $product);
        }
    }

    /** @test */
    public function should_return_order()
    {
        $reconciler = new Reconciler([]);

        $order = $reconciler->reconcile($this->basket);

        $this->assertInstanceOf('PhilipBrown\Merchant\Order', $order);
    }
}
