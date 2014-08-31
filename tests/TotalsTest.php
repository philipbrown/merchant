<?php

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Number;
use PhilipBrown\Merchant\Quantity;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Totals\TotalValue;
use PhilipBrown\Merchant\Totals\TotalProducts;
use PhilipBrown\Merchant\Discounts\ValueDiscount;
use PhilipBrown\Merchant\Jurisdictions\UnitedKingdom;

class TotalsTest extends PHPUnit_Framework_TestCase {

    /** @var Basket */
    private $basket;

    public function setUp()
    {
        $this->basket = new Basket(new UnitedKingdom, new Dispatcher);
        $this->basket->add(SKU::set('1'), Name::set(''), new Money(1000, new Currency('GBP')));
        $this->basket->add(SKU::set('2'), Name::set(''), new Money(2500, new Currency('GBP')), function ($product) {
            $product->setQuantity(Quantity::set(3));
        });
        $this->basket->add(SKU::set('3'), Name::set(''), new Money(1000, new Currency('GBP')), function ($product) {
            $product->setDiscount(new ValueDiscount(new Money(200, new Currency('GBP'))));
            $product->setDelivery(new Money(100, new Currency('GBP')));
        });
    }

    /** @test */
    public function should_count_the_products()
    {
        $total = new TotalProducts;
        $value = $total->calculate($this->basket);

        $this->assertEquals('total_products', $total->name());
        $this->assertEquals(Number::set(5), $value);
    }
}
