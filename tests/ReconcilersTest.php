<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Quantity;
use PhilipBrown\Merchant\Discounts\ValueDiscount;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;
use PhilipBrown\Merchant\Reconcilers\UnitedKingdomReconciler;

class ReconcilersTest extends PHPUnit_Framework_TestCase
{
    /** @var Currency */
    private $currency;

    public function setUp()
    {
        $sku            = SKU::set('');
        $name           = Name::set('');
        $tax            = new UnitedKingdomValueAddedTax;
        $this->currency = new Currency('GBP');

        // Product One
        $this->one = new Product($sku, $name, new Money(1000, $this->currency), $tax);
        // Product Two
        // - quantity x 3
        $this->two = new Product($sku, $name, new Money(200, $this->currency), $tax);
        $this->two->action(function ($product) {
            $product->setQuantity(Quantity::set(3));
        });
        // Product Three
        // - freebie
        $this->three = new Product($sku, $name, new Money(900, $this->currency), $tax);
        $this->three->action(function ($product) {
            $product->setFreebie(Status::set(true));
        });
        // Product Four
        // - not taxable
        $this->four = new Product($sku, $name, new Money(4500, $this->currency), $tax);
        $this->four->action(function ($product) {
            $product->setTaxable(Status::set(false));
        });
        // Product Five
        // - Value Discount
        $this->five = new Product($sku, $name, new Money(5600, $this->currency), $tax);
        $this->five->action(function ($product) {
            $product->setDiscount(new ValueDiscount(new Money(2200, $this->currency)));
        });
        // Product Six
        $this->six = new Product($sku, $name, new Money(1300, $this->currency), $tax);
        $this->six->action(function ($product) {
            $product->setDelivery(new Money(200, $this->currency));
        });
    }

    /** @test */
    public function should_reconcile_value_for_unitedkingdom()
    {
        $reconciler = new UnitedKingdomReconciler;
        $one = $reconciler->value($this->one);
        $two = $reconciler->value($this->two);
        $three = $reconciler->value($this->three);
        $four = $reconciler->value($this->four);
        $five = $reconciler->value($this->five);
        $six = $reconciler->value($this->six);

        $this->assertEquals(new Money(1000, $this->currency), $one);
        $this->assertEquals(new Money(600, $this->currency), $two);
        $this->assertEquals(new Money(900, $this->currency), $three);
        $this->assertEquals(new Money(4500, $this->currency), $four);
        $this->assertEquals(new Money(5600, $this->currency), $five);
        $this->assertEquals(new Money(1300, $this->currency), $six);
    }

    /** @test */
    public function should_reconcile_tax_for_unitedkingdom()
    {
        $reconciler = new UnitedKingdomReconciler;
        $one = $reconciler->tax($this->one);
        $two = $reconciler->tax($this->two);
        $three = $reconciler->tax($this->three);
        $four = $reconciler->tax($this->four);
        $five = $reconciler->tax($this->five);
        $six = $reconciler->tax($this->six);

        $this->assertEquals(new Money(200, $this->currency), $one);
        $this->assertEquals(new Money(120, $this->currency), $two);
        $this->assertEquals(new Money(0, $this->currency), $three);
        $this->assertEquals(new Money(0, $this->currency), $four);
        $this->assertEquals(new Money(680, $this->currency), $five);
        $this->assertEquals(new Money(300, $this->currency), $six);
    }

    /** @test */
    public function should_reconcile_subtotal_for_unitedkingdom()
    {
        $reconciler = new UnitedKingdomReconciler;
        $one = $reconciler->subtotal($this->one);
        $two = $reconciler->subtotal($this->two);
        $three = $reconciler->subtotal($this->three);
        $four = $reconciler->subtotal($this->four);
        $five = $reconciler->subtotal($this->five);
        $six = $reconciler->subtotal($this->six);

        $this->assertEquals(new Money(1000, $this->currency), $one);
        $this->assertEquals(new Money(600, $this->currency), $two);
        $this->assertEquals(new Money(0, $this->currency), $three);
        $this->assertEquals(new Money(4500, $this->currency), $four);
        $this->assertEquals(new Money(3400, $this->currency), $five);
        $this->assertEquals(new Money(1500, $this->currency), $six);
    }

    /** @test */
    public function should_reconcile_total_for_unitedkingdom()
    {
        $reconciler = new UnitedKingdomReconciler;
        $one = $reconciler->total($this->one);
        $two = $reconciler->total($this->two);
        $three = $reconciler->total($this->three);
        $four = $reconciler->total($this->four);
        $five = $reconciler->total($this->five);
        $six = $reconciler->total($this->six);

        $this->assertEquals(new Money(1200, $this->currency), $one);
        $this->assertEquals(new Money(720, $this->currency), $two);
        $this->assertEquals(new Money(0, $this->currency), $three);
        $this->assertEquals(new Money(4500, $this->currency), $four);
        $this->assertEquals(new Money(4080, $this->currency), $five);
        $this->assertEquals(new Money(1800, $this->currency), $six);
    }
}
