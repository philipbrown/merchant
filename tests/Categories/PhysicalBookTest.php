<?php namespace PhilipBrown\Merchant\Tests\Categories;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Categories\PhysicalBook;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class CategoriesTest extends \PHPUnit_Framework_TestCase
{
    /** @var Product */
    private $product;

    public function setUp()
    {
        $sku    = '1';
        $name   = 'Fooled By Randomness';
        $rate   = new UnitedKingdomValueAddedTax;
        $price  = new Money(1000, new Currency('GBP'));
        $this->product = new Product($sku, $name, $price, $rate);
    }

    /** @test */
    public function should_categorise_as_physicalbook()
    {
        $category = new PhysicalBook;
        $category->categorise($this->product);

        $this->assertFalse($this->product->taxable);
    }
}
