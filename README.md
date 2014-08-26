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

There are 3 Value Objects in this package:
```php
use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Quantity;

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
