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
        $this->assertEquals('products', $this->calculator->name());
    }
}
