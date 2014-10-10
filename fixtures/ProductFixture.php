<?php namespace PhilipBrown\Merchant\Fixtures;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class ProductFixture {

    public function load()
    {
        return [
            new Product('1', 'The 4-Hour Work Week', new Money(1000, new Currency('GBP')), new UnitedKingdomValueAddedTax)
        ];
    }
}
