<?php namespace PhilipBrown\Merchant\Tests\Calculators;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Calculators\Subtotal;
use PhilipBrown\Merchant\Fixtures\BasketFixture;
use PhilipBrown\Merchant\Reconcilers\UnitedKingdomReconciler;

class SubtotalTest extends \PHPUnit_Framework_TestCase
{
    /** @var Calculator */
    private $calculator;

    /** @var BasketFixture */
    private $fixtures;

    public function setUp()
    {
        $reconciler       = new UnitedKingdomReconciler;
        $this->fixtures   = new BasketFixture;
        $this->calculator = new Subtotal($reconciler);
    }

    /** @test */
    public function should_return_the_name_of_the_calculator()
    {
        $this->assertEquals('subtotal', $this->calculator->name());
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_zero()
    {
        $basket = $this->fixtures->zero();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(1000, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_one()
    {
        $basket = $this->fixtures->one();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(31497, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_two()
    {
        $basket = $this->fixtures->two();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(89999, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_three()
    {
        $basket = $this->fixtures->three();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(189448, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_four()
    {
        $basket = $this->fixtures->four();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(23868, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_five()
    {
        $basket = $this->fixtures->five();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(91796, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_six()
    {
        $basket = $this->fixtures->six();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(15672, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_seven()
    {
        $basket = $this->fixtures->seven();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(114121, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_eight()
    {
        $basket = $this->fixtures->eight();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(119996, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_nine()
    {
        $basket = $this->fixtures->nine();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(13943, new Currency('GBP')), $total);
    }
}
