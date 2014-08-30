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

The `Product` object requires a `SKU` and a `Name` on instantiation. These values cannot be altered once the object is created.

You will also need to pass an instance of `Money` as the base value of the product as well as a default `TaxRate` instance. You can alter both these two values in a number of different ways as explained below.

### Quantity
By default the quantity of the `Product` object will be set to 1. There are two ways of altering the quantity of a `Product` object.

Firstly, you can pass an instance of `Quantity` to the `quantity()` method:
```php
use PhilipBrown\Merchant\Quantity;

$product->quantity(Quantity::set(5));
```

Secondly, you can increment or decrement the current quantity value by using the `increment()` or `decrement()` methods. This will increase or decrease the value by 1:
```php
$product->increment();
$product->quantity->value(); // 6

$product->decrement();
$product->decrement->value(); // 5
```

### Freebie
The `freebie` status will determine if the value of the current product is included in any reconciliation processes. By default this value is set to `false`.

To alter the `freebie` status you can pass an instance of `Status` to the `freebie()` method:
```php
use PhilipBrown\Merchant\Status;

$product->freebie(Status::set(true));
```

### Taxable
Much like the `freebie` status, the value of the `taxable` status will determine whether the value of the current product is included during any reconciliation processes. By default this value is set to `true`.

To alter the `taxable` status you can pass an instance of `Status` to the `taxable()` method:
```php
use PhilipBrown\Merchant\Status;

$product->taxable(Status::set(false));
```

### Delivery charge
By default the delivery charge of a product will be set to a new instance of `Money` with a value of `0` and the same currency as the value of the `$price`.

To set a delivery charge, pass an instance of `Money` into the `delivery()` method:
```php
use Money\Money;
use Money\Currency;

$product->delivery(new Money(100, new Currency('GBP')));
```

### Coupons and Tags
Coupons and tags won't directly alter any values of the `Product` before or during the reconciliation process. Both coupons and tags are simply string values that are attached to the product and can be used during your sales process or for customer analytics.

To add a coupon or a tag you can use the following methods:
```php
$product->addCoupon(String::set('SUMMER_SALE'));

$product->addTag(String::set('campaign_5742726'));
```

To remove a coupon or a tag you can use the following methods:
```php
$product->removeCoupon(String::('SUMMER_SALE');

$product->removeTag(String::set('campaign_5742726'));
```

### Tax Rate
If you need to set a specific tax rate for a particular product you can do so using the `rate()` method:
```php
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

$product->rate(new UnitedKingdomValueAddedTax);
```

### Discounts
Discounts to be applied to a product should be encapsulated as an object capable of calculating the appropriate discount to apply. This is because the discount is set as an action on the `Product`, but the actual value of the discount is only calculated when the order is reconciled.

Discount objects should provide a `public calculate()` method that accepts an instance of `Product` and a `public value()` method that returns the value of the discount. You can optionally extend the `AbstractDiscount` class.

Discounts should implement the `Discount` interface:
```php
interface Discount
{
    /**
     * Calculate the discount
     *
     * @param PhilipBrown\Merchant\Product
     * @return Money\Money
     */
    public function calculate(Product $product);

    /**
     * Return the value of the Discount
     *
     * @return mixed
     */
    public function value();
}
```

There are two provided `Discount` objects as part of the source of this package, `PercentageDiscount` and `ValueDiscount`.

To set a discount on a product, pass an instance of an object that implements the `Discount` interface to the `discount()` method on the `Product` object:
```php
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;

$product->discount(new PercentageDiscount(Percent::set(50)));
```

### Categories
A category allows you to categorise a product as a certain type and therefore apply a number of properties to the `Product` instance by default.

For example, if products of a certain category should always be tax free and have a certain tag, you would define a category so you could apply the category to each product.

Categories should implement the `Category` inteface:
```php
interface Category
{
    /**
     * Categorise a Product
     *
     * @param Product $product
     * @return void
     */
    public function categorise(Product $product);
}
```

`PhysicalBook` is an example category that will set the `taxable` status of the product to `false`.

To set a category on a product, pass an instance of an object that implements the `Category` interface to the `category()` method on the `Product` object:
```php
use PhilipBrown\Merchant\Categories\PhysicalBook;

$product->category(new PhysicalBook);
```

### Closure of actions
Finally you can pass a `Closure` to the `action()` method on a `Product` instance to run a series of actions against the product. Inside of the closure you will have access to the current `Product`:
```php
use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Quantity;

$product->action(function ($product) {
    $product->quantity(Quantity::set(3));
    $product->freebie(Status::set(true));
    $product->taxable(Status::set(false));
});

$product->quantity->value(); // 3
$product->freebie->value();  // true
$product->taxable->value();  // false
```

## Events
Merchant includes a lightweight event dispatcher for hooking on to events during the lifecycle of the order process. This allows you run certain actions as a consequence of events occuring within the package:
```php
use PhilipBrown\Merchant\Dispatcher;

$dispatcher = new Dispatcher;
```

The `Dispatcher` object is passed into the `Basket` class as a dependency (see below) and will fire events on certain actions.

The list of events are:

- `product.added`
- `product.removed`

To register a listener for an event you should create a new listener class that implements the `Listener` interface:
```php
interface Listener
{
    /**
     * Listen for a Basket Event
     *
     * @param Product $product
     * @param Collection $list
     * @return void
     */
    public function handle(Product $product, Collection $list);
}
```

`RemoveZeroQuantityProductsFromList` is an example listener that is included in the source of Merchant. This listenr will automatically clean up the product list when a product is set to 0 quantity.

To register a listener with the dispatcher, use the `listen()` method and pass the event name and an instance of the `Listener` class:
```php
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Listeners\RemoveZeroQuantityProductsFromList;

$dispatcher = new Dispatcher;
$dispatcher->listen('product.remove', new RemoveZeroQuantityProductsFromList);
```

To fire events, call the `fire()` method on the `Dispatcher` instance and pass the name of the event and the payload.
```php
$dispatcher->fire('product.remove', [$product, $list]);
```
