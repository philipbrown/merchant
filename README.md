# Merchant
**Ecommerce abstraction for dealing with products, orders and sales**

Merchant is a simple abstraction for working with products, orders and sales within an ecommerce application. It aims to solve the problem of dealing with multiple product orders and the associated data that you will be required to store and use within the lifecycle of a customer.

## tl;dr

## Money and Currency
Dealing with Money and Currency in an ecommerce application can be fraught with difficulties. Instead of passing around dumb values, we can use Value Objects that are immuatable and protect the invariants of the items we hope to represent.

This package uses [mathiasverraes/money](https://github.com/mathiasverraes/money) by [@mathiasverraes](https://github.com/mathiasverraes) throughout to represent Money and Currency values.

For further details on how to use these objects, I would recommend taking a look at that repository.

## Tax Rates
In order to correctly calculate the total value of a transaction and the associated tax we need a way to represent the tax rate that should be applied.

For example the included `TaxRates\UnitedKingdomValueAddedTax` represents the tax rate of the United Kingdom.

To create your own tax rate object you will need to implement the `TaxRate` interface:
```php
interface TaxRate {

  /**
   * Return the rate as an float
   *
   * @return int
   */
  public function asFloat();

  /**
   * Return the rate as a percentage
   *
   * @return float
   */
  public function asPercentage();

}
```

Feel free to open a pull request to include your country's tax rate as part of this package.

## Countries
`Country` objects are used to encapsulate the `Currency` and `TaxRate` of a particular country. An example of a country object can be seen under `Countries\UnitedKingdom`.

To create your own country object you will need to implement the `Country` interface:
```php
interface Country {

  /**
   * Return the currency
   *
   * @return Money\Currency
   */
  public function currency();

  /**
   * Return the Tax Rate
   *
   * @return PhilipBrown\Merchant\TaxRate
   */
  public function tax();

}
```

Again, feel free to open a pull request if you want to include your country as part of this package.

## Collections
Arrays in PHP are pretty shit. PHP claims to be an Object Orientated Programming Language, so instead of using boring arrays, we can use collection objects.

The `Collection` class is used in a couple of places around this package for dealing with collections of items.

When you create a new `Collection` instance you can optionally pass in an array of items:
```php
use PhilipBrown\Merchant\Collection;

$collection = new Collection;
$collection = new Collection(['dog', 'cat', 'goat']);
```

The `Collection` class has a number of useful methods for working with a collection of items:
```php
// Return all of the items
$collection->all();

// Get an item by it's key
$collection->key($key);

// Add an item
$collection->add($key, $value);

// Remove an item by it's key
$collection->remove($key);

// Check for an existing item
$collection->contains($key);

// Count the items
$collection->count();

// Get the first item
$collection->first();

// Get the last item
$collection->last();

// Push an item onto the end of the collection
$collection->push($item);
```

## Products
Products are encapsulated as instances of `Product`. The `Product` object allows you to add record the properties of the product in an object orientated way.

To create a new `Product`, pass a [SKU](http://en.wikipedia.org/wiki/Stock_keeping_unit), the name of the product, the price of the product and the tax rate:
```php
use PhilipBrown\Merchant\Product;

$product =  new Product(
  '123',
  'iPhone',
  new Money(60000, new Currency('GBP')),
  new UnitedKingdomValueAddedTax
);
```

- Product properties are gettable
- Certain properties are set as default
- Quantity
- Increment and Decrement values
- Status (Freebie & Taxable)
- Coupons and Tags
- Tax Rate
- Discounts
