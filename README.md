# Merchant
**Ecommerce abstraction for dealing with products, orders and sales**

Merchant is a simple abstraction for working with products, orders and sales within an ecommerce application. It aims to solve the problem of dealing with multiple product orders and the associated data that you will be required to store and use within the lifecycle of a customer.

Merchant aims to solve the following problems:

1. Tracking products through the order process
2. Automatically deal with the issue of money and currency
3. Apply discounts, coupons or special categories to products
4. Automatically calculate totals and other meta data about the order
5. Output the order in a format that is suitable for a HTML view or the response of a Ajax request.

## tl;dr

## Money and Currency
Dealing with Money and Currency in an ecommerce application can be fraught with difficulties. Instead of passing around dumb values, we can use Value Objects that are immuatable and protect the invariants of the items we hope to represent:
```php
use Money\Money;
use Money\Currency;

$price = new Money(500, new Currency('GBP'));
```

Equality is important to working with many different types of currency. You shouldn't be able to blindly add two different currencies without some kind of exchange process:
```php
$money1 = new Money(500, new Currency('GBP'));
$money2 = new Money(500, new Currency('USD'));

// Throws Money\InvalidArgumentException
$money->add($money2);
```

This package uses [mathiasverraes/money](https://github.com/mathiasverraes/money) by [@mathiasverraes](https://github.com/mathiasverraes) throughout to represent Money and Currency values.

## Value Objects
In order to define the rules around accepted input types, this package uses Value Objects. A Value Object is an object that represents an entity whose equality isn't based on identity: i.e. two value objects are equal when they have the same value, not necessarily being the same object.

This means we can define the rules of the input type inside of the object and type hint for that object where appropriate. This allows us to define the rules internally to the object so we don't have to protect against invalid input types in other classes.

Value Objects should implement the `ValueObject` interface:
```php
interface ValueObject
{
    /**
     * Static method to create a new instance
     *
     * @param mixed $value
     * @return ValueObject
     */
    public static function set($value);

    /**
     * Return the value of the object
     *
     * @return mixed
     */
    public function value();

    /**
     * Test equality with another ValueObject
     *
     * @param ValueObject $object
     * @return bool
     */
    public function equals(ValueObject $object);
}
```

Each Value Object should have a `public static set($value)` method and a `private __construct()` method. The `value()` method and the `equals(Value $object)` method can be inherited from the `AbstractValueObject` class.

This package uses [beberlei/assert](https://github.com/beberlei/assert) by [@beberlei](https://github.com/beberlei) to protect against invalid inputs. If you pass an invalid input to a Value Object a `Assert\AssertionFailedException` will be thrown.

There are a couple of Value Objects in this package:
```php
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Quantity;

// A `SKU` should be a string value
$sku = SKU::set('abc123');
$sku->value(); // 'abc123'

// A `Name` should be a string value
$name = Name::set('iPhone');
$name->value(); // 'iPhone'

// A `Status` should be a boolean value
$status = Status::set(true);
$status->value(); // true

// A `Quantity` should be an integer value
$quantity = Quantity::set(10);
$quantity->value(); // 10

// A `Percent` should be an integer value
$percent = Percent::set(10);
$percent->value(); // 10

// You can test for equality between two Value Objects
$other = Percent::set(10);
$other->equals($percent);   // true
$other->equals($quantity);  // false
```

Certain Value Object also have extra methods. Each method that manipulates the value of the Value Object will return a new instance to ensure immutability.

For example, `string` Value Objects extend the `String` class:
```php
use PhilipBrown\Merchant\String;

$string = String::set('HelloWorld');
$snaked = $string->snake();

$string->value(); // 'HelloWorld'
$snaked->value(); // 'hello_world'
```

And `integer` Value Objects extend the `Number` class:
```php
use PhilipBrown\Merchant\Number;

$number = Number::set(10);
$bigger = $number->increment();

$number->value(); // 10
$bigger->value(); // 11
```

## Tax Rates
When calculating the total cost of an order we need to factor in the tax rate that should be applied on top. Tax Rates are encapsulated as objects so we can provide a consistent interface when retrieving the current rate of tax.

Tax rates should implement the `TaxRate` interface:
```php
interface TaxRate
{
    /**
     * Return the rate as a float
     *
     * @return float
     */
    public function asFloat();

    /**
     * Return the rate as a percentage
     *
     * @return int
     */
    public function asPercentage();
}
```

An example `UnitedKingdomValueAddedTax` implementation can be found in this package. If you would like to add a tax rate to the core Merchant source, please feel free to open a pull request.

## Jurisdictions
Almost every country in the world has a different combination of currency and tax rates. Countries like the USA event have different tax rates within each state.

In order to make it easier to work with currency and tax rate combinations you think of the combination as an encapsulated "jurisdication". This means you can easily specify the currency and tax rate to be used depending on the locale of the current customer.

Jurisdictions should implement the `Jurisdiction` interface:
```php
interface Jurisdiction
{
    /**
     * Return the currency
     *
     * @return Money\Currency
     */
    public function currency();

    /**
     * Return the Tax Rate
     *
     * @return TaxRate
     */
    public function tax();
}
```
Again, if you would like to add a jurisdiction to the core Merchant source, please feel free to open a pull request.

## Collections
A collection is an object orientated version of an array that allows you to iterate over a collection of items. This package uses instances of `Collection` to make working with collections of items easier.

You can create a new `Collection` by instantiating a new object and optionally passing an array of items:
```php
use PhilipBrown\Merchant\Collection;

$items = ['Homer', 'Marge', 'Bart', 'Lisa', 'Maggie'];

$collection = new Collection;
$collection = new Collection($this->items);
```

The `Collection` object has a number of methods for working with a collection of items:
```php
// Get all items from the collection
$family = $collection->all();
// ['Homer', 'Marge', 'Bart', 'Lisa', 'Maggie'];

// Get a single item by it's key
$lisa = $this->collection->get(3);
// 'Lisa'

// Add an item
$collection->add(5, 'Snowball II');
$collection->get(5);
// 'Snowball II'

// Check for an item
$collection->contains('Bart');
// bool

// Count the number of items
$collection->count();
// 5

// Run a callback on each item
$collection->each(function ($person) {
    is_string($person);
});
// true, true, true, true, true

// Filter a collection with a callback
$filtered = $collection->filter(function ($person) {
    return substr($person, 0,1) === 'M';
});
// ['Marge', 'Maggie']

// Check for emptyness
$other = new Collection;
$other->isEmpty();
// true

// Get the keys of the items
$keys = $collection->keys();
// [0, 1, 2, 3, 4]

// Get the first item
$homer = $collection->first();
// 'Homer'

// Get the last item
$maggie = $collection->last();
// 'Maggie'

// Run a map over each item
$collection->map(function ($person) {
    return $person.' Simpson';
});
// ['Homer Simpson', 'Marge Simpson', 'Bart Simpson', 'Lisa Simpson', 'Maggie Simpson']

// Push an item on to the end
$collection->push("Santa's Little Helper");
$collection->get(6);
// "Santa's Little Helper"

// Pop the last item
$maggie = $collection->pop();
// 'Maggie'

// Prepend an item to the start of the collection
$collection->prepend('Abe');
$collection->get(0);
// 'Abe'

// Remove an item
$collection->remove(0);
$collection->count();
// 4

// Seach the items
$key = $collection->seach('Bart');
// 2

// Get and remove the first item
$homer = $collection->shift();
$collection->count();
// Homer
// 4

// Sort the items and reset the keys
$collection->sort(function ($a, $b) {
    if ($a == $b) return 0;

    return ($a < $b) ? -1 : 1;
});

$collection->values();
// ['Bart', 'Homer', 'Lisa', 'Maggie', 'Marge']
```

## Products
Products in this package are encapsulated as instances of `Product`. To create a new `Product`;
```php
use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\SKU;
use PhilipBrown\Merchant\Name;
use PhilipBrown\Merchant\Product;
use PhilipBrown\Merchant\Stubs\StubTaxRate;

$sku      = SKU::set('abc123');
$name     = Name::set('iPhone');
$price    = new Money(100, new Currency('GBP'));
$rate     = new StubTaxRate;
$product  = new Product($sku, $name, $price, $rate);
```
