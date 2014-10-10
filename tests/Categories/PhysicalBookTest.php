<?php namespace PhilipBrown\Merchant\Tests\Categories;

use PhilipBrown\Merchant\Fixtures\ProductFixture;
use PhilipBrown\Merchant\Categories\PhysicalBook;

class CategoriesTest extends \PHPUnit_Framework_TestCase
{
    /** @var array */
    private $products;

    public function setUp()
    {
        $this->products = (new ProductFixture)->load();
    }

    /** @test */
    public function should_categorise_as_physicalbook()
    {
        $category = new PhysicalBook;
        $category->categorise($this->products[0]);

        $this->assertFalse($this->products[0]->taxable);
    }
}
