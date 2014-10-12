<?php namespace PhilipBrown\Merchant\Fixtures;

use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Categories\PhysicalBook;
use PhilipBrown\Merchant\Discounts\ValueDiscount;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

class ProductFixture
{
    /**
     * @var array
     */
    private $methods;

    /**
     * Create a new ProductFixture
     *
     * @return void
     */
    public function __construct()
    {
        $this->methods = [
            'zero',
            'one',
            'two',
            'three',
            'four',
            'five',
            'six',
            'seven',
            'eight',
            'nine'
        ];
    }

    /**
     * Load the fixtures
     *
     * @return array
     */
    public function load()
    {
        $products = [];

        foreach ($this->methods as $method) {
            $products[] = $this->$method();
        }

        return $products;
    }

    /**
     * Regular Product
     *
     * Price:    £10.00
     * Rate:     20%
     * Quantity: 1
     * Freebie:  false
     * Taxable:  true
     * Discount: £0
     * Delivery: £0
     *
     * @return Product
     */
    public function zero()
    {
        $sku     = '0';
        $name    = 'Back to the Future Blu-ray';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(1000, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);

        return $product;
    }

    /**
     * Physical Book
     *
     * Price:    £15.00
     * Rate:     0%
     * Quantity: 1
     * Freebie:  false
     * Taxable:  false
     * Discount: £0
     * Delivery: £0
     *
     * @return Product
     */
    public function one()
    {
        $sku     = '1';
        $name    = 'The 4-Hour Work Week';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(1500, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);
        $product->category(new PhysicalBook);

        return $product;
    }

    /**
     * Multiple Quantity
     *
     * Price:    £99.99
     * Rate:     20%
     * Quantity: 3
     * Freebie:  false
     * Taxable:  true
     * Discount: £0
     * Delivery: £0
     *
     * @return Product
     */
    public function two()
    {
        $sku     = '2';
        $name    = 'Kindle';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(9999, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);
        $product->quantity(3);

        return $product;
    }

    /**
     * Freebie
     *
     * Price:    £4.99
     * Rate:     0%
     * Quantity: 1
     * Freebie:  true
     * Taxable:  false
     * Discount: £0
     * Delivery: £0
     *
     * @return Product
     */
    public function three()
    {
        $sku     = '3';
        $name    = 'iPhone case';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(499, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);
        $product->freebie(true);

        return $product;
    }

    /**
     * Percentage Discount
     *
     * Price:    £999.99
     * Rate:     20%
     * Quantity: 1
     * Freebie:  false
     * Taxable:  true
     * Discount: 10%
     * Delivery: £0
     *
     * @return Product
     */
    public function four()
    {
        $sku     = '4';
        $name    = 'MacBook Air';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(99999, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);
        $product->discount(new PercentageDiscount(10));

        return $product;
    }

    /**
     * Value Discount
     *
     * Price:    £49.50
     * Rate:     20%
     * Quantity: 1
     * Freebie:  false
     * Taxable:  true
     * Discount: £15
     * Delivery: £0
     *
     * @return Product
     */
    public function five()
    {
        $sku     = '5';
        $name    = 'Sega Mega Drive';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(4950, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);
        $product->discount(new ValueDiscount(new Money(1500, new Currency('GBP'))));

        return $product;
    }

    /**
     * Delivery
     *
     * Price:    £899.99
     * Rate:     20%
     * Quantity: 1
     * Freebie:  false
     * Taxable:  true
     * Discount: £0
     * Delivery: £60
     *
     * @return Product
     */
    public function six()
    {
        $sku     = '6';
        $name    = 'Aeron Chair';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(89999, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);
        $product->delivery(new Money(6000, new Currency('GBP')));

        return $product;
    }

    /**
     * Quantity * 4 + 10% Discount + Delivery
     *
     * Price:    £32.99
     * Rate:     20%
     * Quantity: 4
     * Freebie:  false
     * Taxable:  true
     * Discount: 10%
     * Delivery: £6.99
     *
     * @return Product
     */
    public function seven()
    {
        $sku     = '7';
        $name    = 'Kettlebell';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(3299, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);
        $product->quantity(4);
        $product->discount(new PercentageDiscount(10));
        $product->delivery(new Money(699, new Currency('GBP')));

        return $product;
    }

    /**
     * Quantity * 2 + 0% Rate + Delivery
     *
     * Price:    £39.99
     * Rate:     0%
     * Quantity: 2
     * Freebie:  false
     * Taxable:  false
     * Discount: £0
     * Delivery: £5.99
     *
     * @return Product
     */
    public function eight()
    {
        $sku     = '8';
        $name    = 'Junior Jordans';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(3999, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);
        $product->quantity(2);
        $product->taxable(false);
        $product->delivery(new Money(599, new Currency('GBP')));

        return $product;
    }

    /**
     * Quantity * 3 + Freebie + Delivery
     *
     * Price:    £25.00
     * Rate:     0%
     * Quantity: 3
     * Freebie:  true
     * Taxable:  false
     * Discount: £0
     * Delivery: £0.99
     *
     * @return Product
     */
    public function nine()
    {
        $sku     = '9';
        $name    = 'Gift Card';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(2500, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);
        $product->quantity(3);
        $product->freebie(true);
        $product->delivery(new Money(99, new Currency('GBP')));

        return $product;
    }
}
