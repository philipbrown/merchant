<?php namespace PhilipBrown\Merchant\Tests\Calculators;

use PhilipBrown\Merchant\Fixtures\BasketFixture;
use PhilipBrown\Merchant\Calculators\ProductsCalculator;

class ProductsCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Calculator */
    private $calculator;

    /** @var BasketFixture */
    private $fixtures;

    public function setUp()
    {
        $this->fixtures   = new BasketFixture;
        $this->calculator = new ProductsCalculator;
    }

    /** @test */
    public function should_return_the_name_of_the_calculator()
    {
        $this->assertEquals('products_count', $this->calculator->name());
    }

    /** @test */
    public function should_calculate_the_number_of_products_for_basket_fixture_zero()
    {
        $basket = $this->fixtures->zero();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(1, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_products_for_basket_fixture_one()
    {
        $basket = $this->fixtures->one();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(4, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_products_for_basket_fixture_two()
    {
        $basket = $this->fixtures->two();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(2, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_products_for_basket_fixture_three()
    {
        $basket = $this->fixtures->three();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(3, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_products_for_basket_fixture_four()
    {
        $basket = $this->fixtures->four();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(6, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_products_for_basket_fixture_five()
    {
        $basket = $this->fixtures->five();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(5, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_products_for_basket_fixture_six()
    {
        $basket = $this->fixtures->six();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(6, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_products_for_basket_fixture_seven()
    {
        $basket = $this->fixtures->seven();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(6, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_products_for_basket_fixture_eight()
    {
        $basket = $this->fixtures->eight();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(5, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_products_for_basket_fixture_nine()
    {
        $basket = $this->fixtures->nine();

        $total = $this->calculator->calculate($basket);

        $this->assertEquals(7, $total);
    }
}
