<?php namespace PhilipBrown\Merchant\Tests\Calculators;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Calculators\TotalValue;
use PhilipBrown\Merchant\Fixtures\BasketFixture;
use PhilipBrown\Merchant\Reconcilers\UnitedKingdomReconciler;

class TotalValueTest extends \PHPUnit_Framework_TestCase
{
    /** @var Calculator */
    private $calculator;

    /** @var BasketFixture */
    private $fixtures;

    public function setUp()
    {
        $reconciler       = new UnitedKingdomReconciler;
        $this->fixtures   = new BasketFixture;
        $this->calculator = new TotalValue($reconciler);
    }

    /** @test */
    public function should_return_the_name_of_the_calculator()
    {
        $this->assertEquals('total_value', $this->calculator->name());
    }

    /** @test */
    public function should_calculate_the_total_value_for_basket_fixture_zero()
    {
        $basket = $this->fixtures->zero();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(1000, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_value_for_basket_fixture_one()
    {
        $basket = $this->fixtures->one();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(31497, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_value_for_basket_fixture_two()
    {
        $basket = $this->fixtures->two();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(100498, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_value_for_basket_fixture_three()
    {
        $basket = $this->fixtures->three();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(194948, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_value_for_basket_fixture_four()
    {
        $basket = $this->fixtures->four();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(21194, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_value_for_basket_fixture_five()
    {
        $basket = $this->fixtures->five();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(108999, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_value_for_basket_fixture_six()
    {
        $basket = $this->fixtures->six();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(14695, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_value_for_basket_fixture_seven()
    {
        $basket = $this->fixtures->seven();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(108145, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_value_for_basket_fixture_eight()
    {
        $basket = $this->fixtures->eight();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(130495, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_value_for_basket_fixture_nine()
    {
        $basket = $this->fixtures->nine();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(new Money(21448, new Currency('GBP')), $total);
    }
}
