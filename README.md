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

$one = Number::set(10);
$two = $one->add(Number::set(2));
$two->value(); // 12

$three = $one->subtract(Number::set(3));
$three->value(); // 7

$four = $one->multply(Number::set(10));
$four->value(); // 100

$five = $one->divide(Number::set(5));
$five->value(); // 2
```

Merchant also includes a generic immutable `Object` class that accepts an associative array on instantiation and then provides those values within the context of an object:
```php
use PhilipBrown\Merchant\Object;

$object = new Object(['hello' => 'world']);

$object->hello; // 'world'
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

Firstly, you can pass an instance of `Quantity` to the `setQuantity()` method:
```php
use PhilipBrown\Merchant\Quantity;

$product->setQuantity(Quantity::set(5));

$product->quantity()->value(); // 5
```

Secondly, you can increment or decrement the current quantity value by using the `increment()` or `decrement()` methods. This will increase or decrease the value by 1:
```php
$product->increment();
$product->quantity()->value(); // 6

$product->decrement();
$product->decrement()->value(); // 5
```

### Freebie
The `freebie` status will determine if the value of the current product is included in any reconciliation processes. By default this value is set to `false`.

To alter the `freebie` status you can pass an instance of `Status` to the `setFreebie()` method:
```php
use PhilipBrown\Merchant\Status;

$product->setFreebie(Status::set(true));

$product->freebie()->value(); // true
```

### Taxable
Much like the `freebie` status, the value of the `taxable` status will determine whether the value of the current product is included during any reconciliation processes. By default this value is set to `true`.

To alter the `taxable` status you can pass an instance of `Status` to the `setTaxable()` method:
```php
use PhilipBrown\Merchant\Status;

$product->setTaxable(Status::set(false));

$product->taxable()->value(); // false
```

### Delivery charge
By default the delivery charge of a product will be set to a new instance of `Money` with a value of `0` and the same currency as the value of the `$price`.

To set a delivery charge, pass an instance of `Money` into the `setDelivery()` method:
```php
use Money\Money;
use Money\Currency;

$product->setDelivery(new Money(100, new Currency('GBP')));

$product->delivery(); // Money
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

To get access to the underlying `Collection` instances you can use the following methods:
```php
$product->coupons(); // Collection
$product->tags();    // Collection

### Tax Rate
If you need to set a specific tax rate for a particular product you can do so using the `setRate()` method:
```php
use PhilipBrown\Merchant\TaxRates\UnitedKingdomValueAddedTax;

$product->setRate(new UnitedKingdomValueAddedTax);

$product->rate(); // UnitedKingdomValueAddedTax
```

### Discounts
Discounts to be applied to a product should be encapsulated as an object capable of calculating the appropriate discount to apply.

Discount objects should provide a `public calculate()` method that accepts an instance of `Product` and a `public rate()` method that returns the rate of the discount. You can optionally extend the `AbstractDiscount` class.

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
     * Return the rate of the Discount
     *
     * @return mixed
     */
    public function rate();
}
```

There are two provided `Discount` objects as part of the source of this package, `PercentageDiscount` and `ValueDiscount`.

To set a discount on a product, pass an instance of an object that implements the `Discount` interface to the `setdDiscount()` method on the `Product` object:
```php
use PhilipBrown\Merchant\Percent;
use PhilipBrown\Merchant\Discounts\PercentageDiscount;

$product->setDiscount(new PercentageDiscount(Percent::set(50)));
```

You can access the `value` and the `rate` of the discount through the `discount()` method. This method will return an instance of `PhilipBrown\Merchant\Object`. This is an immutable object that has two `private` properties that are exposed as `__get()` attributes:
```php
$product->discount()->value; // Money
$product->discount()->rate;  // Percent
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

To set a category on a product, pass an instance of an object that implements the `Category` interface to the `setCategory()` method on the `Product` object:
```php
use PhilipBrown\Merchant\Categories\PhysicalBook;

$product->setCategory(new PhysicalBook);
```

### Closure of actions
Finally you can pass a `Closure` to the `action()` method on a `Product` instance to run a series of actions against the product. Inside of the closure you will have access to the current `Product`:
```php
use PhilipBrown\Merchant\Status;
use PhilipBrown\Merchant\Quantity;

$product->action(function ($product) {
    $product->setQuantity(Quantity::set(3));
    $product->setFreebie(Status::set(true));
    $product->setTaxable(Status::set(false));
});

$product->quantity()->value(); // 3
$product->freebie()->value();  // true
$product->taxable()->value();  // false
```

## Product Reconciliation
The process for reconciliating products, calculating tax, applying discounts etc, etc is such a fragmented process that it would be impossible to encapsulate a set of rules within a single object.

Instead I've provided an interface where you can define your own rules for how you want to reconcile products.

Your reconciler class should implement the following interface:
```php
interface Reconciler {

    /**
     * Return the value of the Product
     *
     * @return Money
     */
    public function value(Product $product);

    /**
     * Return the tax of the Product
     *
     * @return Money
     */
    public function tax(Product $product);

    /**
     * Return the subtotal of the Product
     *
     * @return Money
     */
    public function subtotal(Product $product);

    /**
     * Return the total of the Product
     *
     * @return Money
     */
    public function total(Product $product);

}
```

`UnitedKingdomReconciler` is an example of the general rules that should be following in the United Kingdom.

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

## Basket
The main interface of interaction inside your application with Merchant will be through the `Basket` object. The `Basket` object manages the adding and removing of products from the product list internally as well as firing events on the appropriate actions.

To create a new `Basket` instance, pass the current `Jurisdiction` and an instance of the `Dispatcher`:
```php
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Dispatcher;
use PhilipBrown\Merchant\Jurisdictions\UnitedKingdom;

$basket = new Basket(new UnitedKingdom, new Dispatcher);
```

The `Basket` accepts the `Jurisdiction` instance but manages the tax rate and the currency as two seperate properties. Those two objects are available through the following two methods:
```php
$basket->rate();     // PhilipBrown\Merchant\TaxRate
$basket->currency(); // PhilipBrown\Merchant\Currency
```

The `Basket` will automatically create a new `Collection` instance to internally manage the `Product` instances of the current order.

You can interact with the product list using the following methods:
```php
// Get the count of the products
$basket->count();

// Pick a product from the basket via it's SKU
$product = $basket->pick(SKU::set('abc123'));

// Return the Collection of products
$products = $basket->products();
```

To add a product to the basket, pass the SKU, name and price to the `add()` method:
```php
use Money\Money;
use Money\Currency;

$sku    = SKU::set('abc123');
$name   = SKU::name('iPhone');
$price  = new Money(100, new Currency('GBP'));

$basket->add($sku, $name, $price);
```

You can also optionally pass a fourth parameter of a `Closure` to run actions on the new product:
$basket->add(SKU::set('abc123'), Name::set('iPhone'), new Money(100, new Currency('GBP')));
```php
use Money\Money;
use Money\Currency;
use PhilipBrown\Merchant\Status;

$sku    = SKU::set('abc123');
$name   = SKU::name('iPhone');
$price  = new Money(100, new Currency('GBP'));

$basket->add($sku, $name, $price, function ($product) {
    $product->setTaxable(Status::set(false));
});
```

You can remove a product from the basket by passing a SKU to the `remove()` method:
```php
$basket->remove(SKU::set('abc123'));
```

## Totals
When working with an order of products, there will be certain bits of meta data that you want to collection such as the total number of products, the total value of the products or the total tax of the order.

Certain types of ecommerce applications will require a limited amount of meta data, whilst others will require much more indepth meta data that would be out of the scope for the majority of cases.

Each calculation process should be encapsulated as a class and should implement the `Total` interface:
```php
interface Total
{
    /**
     * Run calculation
     *
     * @param Basket $basket
     * @return mixed
     */
    public function calculate(Basket $basket);

    /**
     * Get the name of the Total
     *
     * @return string
     */
    public function name();
}
```
The `calculate()` method accepts an instance of the `Basket` and should return the value of the meta item you want to return.

The `name()` method can be implement by extending the `AbstractTotal` abstract class.

Merchant includes the following `Total` classes:

- `Total`
- `Subtotal`
- `TotalTax`
- `TotalValue`
- `TotalDiscount`
- `TotalDelivery`
- `TotalProducts`
- `TotalTaxableItems`

If you would like to include a `Total` class as part of the main Merchant source code, please feel free to open a pull request.

## Processing an Order
After you have finished interacting with the `Basket` it is time to process it and turn it into an immutable `Order` object. The `Processor` class will simply iterate through the `Total` classes you have injected and return a new `Order` instance:
```php
use PhilipBrown\Merchant\Processor;
use PhilipBrown\Merchant\Totals\TotalProducts;

$processor = new Processor([new TotalProducts]);

$order = $processor->process($basket);
```

`Order` is a simple immutable object with two `public` methods for returning the `totals` and the `products` of the order:
```php
$order->totals();   // Collection
$order->products(); // Collection
```
