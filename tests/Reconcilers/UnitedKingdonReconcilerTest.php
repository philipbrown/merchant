<?php namespace PhilipBrown\Merchant\Tests\Reconcilers;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Fixtures\ProductFixture;
use PhilipBrown\Merchant\Reconcilers\UnitedKingdomReconciler;

class UnitedKingdomReconcilerTests extends \PHPUnit_Framework_TestCase
{
    /** @var array */
    private $products;

    /** @var Reconciler */
    private $reconciler;

    public function setUp()
    {
        $this->products   = (new ProductFixture)->load();
        $this->reconciler = new UnitedKingdomReconciler;
    }

    /** @test */
    public function should_calculate_the_value()
    {
        $value = $this->reconciler->value($this->products[0]);

        $this->assertEquals(new Money(1000, new Currency('GBP')), $value);
    }

    /** @test */
    public function should_calculate_the_tax()
    {
        $tax = $this->reconciler->tax($this->products[0]);

        $this->assertEquals(new Money(200, new Currency('GBP')), $tax);
    }

    /** @test */
    public function should_caluclate_subtotal()
    {
        $subtotal = $this->reconciler->subtotal($this->products[0]);

        $this->assertEquals(new Money(1000, new Currency('GBP')), $subtotal);
    }

    /** @test */
    public function should_calculate_total()
    {
        $total = $this->reconciler->total($this->products[0]);

        $this->assertEquals(new Money(1200, new Currency('GBP')), $total);
    }
}
