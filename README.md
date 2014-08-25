# Merchant
**Ecommerce abstraction for dealing with products, orders and sales**

Merchant is a simple abstraction for working with products, orders and sales within an ecommerce application. It aims to solve the problem of dealing with multiple product orders and the associated data that you will be required to store and use within the lifecycle of a customer.

## tl;dr

## Money and Currency
Dealing with Money and Currency in an ecommerce application can be fraught with difficulties. Instead of passing around dumb values, we can use Value Objects that are immuatable and protect the invariants of the items we hope to represent.

This package uses [mathiasverraes/money](https://github.com/mathiasverraes/money) by [@mathiasverraes](https://github.com/mathiasverraes) throughout to represent Money and Currency values.

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
// Return all of the items as an array
$collection->all();

// Get an item by it's key
$collection->key($key);

// Add an item with a key
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
Products are encapsulated as instances of `Product`. The `Product` object allows you to work with the properties of the product in an object orientated way.

To create a new `Product`, pass a [SKU](http://en.wikipedia.org/wiki/Stock_keeping_unit), the name of the product, the price of the product and the tax rate:
```php
use PhilipBrown\Merchant\Product;

$sku    = '123';
$name   = 'iPhone';
$price  = new Money(60000, new Currency('GBP'));
$rate   = new UnitedKingdomValueAddedTax;

$product =  new Product($sku, $name, $price, $rate);
```

The properties of a `Product` instance are set to `private` but the object implements PHP's `__get()` magic method to allow you to get them as if they were `public` class properties:
```php
$product->sku;  // 123
$product->name; // iPhone
```

The `Product` object also has certain properties that are set as default but cannot be set during instantiation:
```php
$product->quantity; // 1
$product->freebie;  // false
$product->taxable;  // true
```

### Quantity
You can alter the quantity of a `Product` in two ways.

Firstly you can pass an instance of `Quantity` into the `quantity()` method. `Quantity` is a simple immutable Value Object that has a single `static set()` method and a `private __construct()` method:
```php
use PhilipBrown\Merchant\Quantity;

$product->quantity(Quantity::set(10));
```

Alternatively you can increment of decrement the quantity using the respective methods:
```php
// Increment the quantity
$product->increment(); // ++

// Decrement the quantity
$product->decrement(); // --
```

### Freebie and Taxable
The `freebie` and the `taxable` properties can be altered by passing an instance of the `Status` Value Object into the `freebie()` or `taxable()` methods. As with the `Quantity` Value Object, the `Status` Value Object has a single `static set()` method and a `private __construct()` method:
```php
use PhilipBrown\Merchant\Status;

// Set the freebie status
$product->freebie(Status::set(true));

// Set the taxable status
$product->taxable(Status::set(false));
```

### Coupons and Tags
The `Product` object will by default instantiate instances of `Collection` for the `coupon` and `tags` properties. You can add a coupon or a tag to the product by using either the `coupon()` or `tags()` methods:
```php
// Add a coupon
$product->coupon('SUMMERSALE2014');

// Add a tag
$product->tag('digital');
```

### Tax Rate
If you want to apply an alternate tax rate to a product you can do so by passing an object that implements the `TaxRate` interface to the `rate()` method:
```php
$product->rate(new SpecialTaxRate);
```

### Discounts
To set a discount on a product, pass an object that implements the `Discount` interface to the `discount()` method. Two example discount objects have been provided as part of this package:
```php
use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Percentage;
use PhilipBrown\Merchant\Discounts\ValueDiscount;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;

// Set a discount of a fixed value
$product->discount(new ValueDiscount(new Money(200, new Currency('GBP'))));

// Set a discount of a percentage of the product price
$product->discount(new PercentageDiscount(Percentage::set(20)));
```

### Categories
You can also define a categories so that all products of that category will be set with the same consistent values. To set the category of a product you can pass an object that implements the `Category` interface to the `category()` method. A `PhysicalBook` category has been provided as part of this package as an example:
```php
$product->category(new PhysicalBook);
```

### Actions
If you want to run a series of actions to all products you can pass a `Closure` to the `action()` method. Inside of the `Closure` you will have access to the currenct `$product` instance:
```php
$product->action(function($product)
{
  $product->quantity(Quantity::set(3));
  $product->freebie(Status::set(true));
  $product->taxable(Status::set(false));
});
```

## Events
- Dispatcher
- Listeners

## Basket
- Set up the basket
- add a product
- count the products
- pick a product
- remove a product

## Totals
- Calculate
- Provide the name of the total

## Reconciling
- Reconciling
- Order
- Line Items
