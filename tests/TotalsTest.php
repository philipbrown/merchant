<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Number;
use PhilipBrown\Merchant\Quantity;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Totals\Total;
use PhilipBrown\Merchant\Totals\SubTotal;
use PhilipBrown\Merchant\Totals\TotalTax;
use PhilipBrown\Merchant\Totals\TotalValue;
use PhilipBrown\Merchant\Totals\TotalDelivery;
use PhilipBrown\Merchant\Totals\TotalDiscount;
use PhilipBrown\Merchant\Totals\TotalProducts;
use PhilipBrown\Merchant\Discounts\ValueDiscount;
use PhilipBrown\Merchant\Totals\TotalTaxableItems;
use PhilipBrown\Merchant\Jurisdictions\UnitedKingdom;
use PhilipBrown\Merchant\Reconcilers\UnitedKingdomReconciler;

class TotalsTest extends PHPUnit_Framework_TestCase {

    /** @var Basket */
    private $basket;

    public function setUp()
    {
        $this->basket = new Basket(new UnitedKingdom, new Dispatcher);
        $this->basket->add(SKU::set('1'), Name::set(''), new Money(1000, new Currency('GBP')));
        $this->basket->add(SKU::set('2'), Name::set(''), new Money(1200, new Currency('GBP')), function ($product) {
            $product->setTaxable(Status::set(false));
        });
        $this->basket->add(SKU::set('3'), Name::set(''), new Money(2500, new Currency('GBP')), function ($product) {
            $product->setQuantity(Quantity::set(3));
        });
        $this->basket->add(SKU::set('4'), Name::set(''), new Money(1000, new Currency('GBP')), function ($product) {
            $product->setDiscount(new ValueDiscount(new Money(200, new Currency('GBP'))));
            $product->setDelivery(new Money(100, new Currency('GBP')));
        });
        $this->basket->add(SKU::set('5'), Name::set(''), new Money(550, new Currency('GBP')), function ($product) {
            $product->setFreebie(Status::set(true));
        });
    }

    /** @test */
    public function should_count_the_products()
    {
        $total = new TotalProducts;
        $value = $total->calculate($this->basket);

        $this->assertEquals('total_products', $total->name());
        $this->assertEquals(Number::set(7), $value);
    }

    /** @test */
    public function should_total_the_value_of_the_products()
    {
        $total = new TotalValue(new UnitedKingdomReconciler);
        $value = $total->calculate($this->basket);

        $this->assertEquals('total_value', $total->name());
        $this->assertEquals(new Money(11250 , new Currency('GBP')), $value);
    }

    /** @test */
    public function should_calculate_the_total_discount()
    {
        $total = new TotalDiscount;
        $value = $total->calculate($this->basket);

        $this->assertEquals('total_discount', $total->name());
        $this->assertEquals(new Money(200, new Currency('GBP')), $value);
    }

    /** @test */
    public function should_calculate_the_total_delivery()
    {
        $total = new TotalDelivery;
        $value = $total->calculate($this->basket);

        $this->assertEquals('total_delivery', $total->name());
        $this->assertEquals(new Money(100, new Currency('GBP')), $value);
    }

    /** @test */
    public function should_calculate_total_tax()
    {
        $total = new TotalTax(new UnitedKingdomReconciler);
        $value = $total->calculate($this->basket);

        $this->assertEquals('total_tax', $total->name());
        $this->assertEquals(new Money(1880, new Currency('GBP')), $value);
    }

    /** @test */
    public function should_calculate_subtotal()
    {
        $total = new Subtotal(new UnitedKingdomReconciler);
        $value = $total->calculate($this->basket);

        $this->assertEquals('subtotal', $total->name());
        $this->assertEquals(new Money(10600, new Currency('GBP')), $value);
    }

    /** @test */
    public function should_calculate_the_total()
    {
        $total = new Total(new UnitedKingdomReconciler);
        $value = $total->calculate($this->basket);

        $this->assertEquals('total', $total->name());
        $this->assertEquals(new Money(12480, new Currency('GBP')), $value);
    }

    /** @test */
    public function should_count_total_taxable_items()
    {
        $total = new TotalTaxableItems;
        $value = $total->calculate($this->basket);

        $this->assertEquals('total_taxable_items', $total->name());
        $this->assertEquals(Number::set(6), $value);
    }
}
