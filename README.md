# Merchant
**Ecommerce abstraction for dealing with products, orders and sales**

[![Build Status](https://travis-ci.org/philipbrown/merchant.png?branch=master)](https://travis-ci.org/philipbrown/merchant)

Merchant is a simple abstraction for working with products, orders and sales within an ecommerce application. It aims to solve the problem of dealing with multiple product orders and the associated data that you will be required to store and use within the lifecycle of a customer.

## Installation
Add `philipbrown/merchant` as a requirement to `composer.json`:

```json
{
  "require": {
    "philipbrown/merchant": "dev-master"
  }
}
```
Update your packages with `composer update`.

## Usage
The primary purpose of Merchant is a way to store and organise the data about each individual product with an order or a sale and then to find the aggregate totals using a simple interface.

### Regions
Due to the fragmented situation of the world's financial rules and regulations, Merchant is broken into individual regions. Each region has specific data set as properties that are applicable in that region.

For example, England is represented as:
```php
<?php namespace Philipbrown\Merchant\Region;

use Philipbrown\Merchant\AbstractRegion;
use Philipbrown\Merchant\RegionInterface;

class England extends AbstractRegion implements RegionInterface {

  /**
   * @var string
   */
  protected $name = 'England';

  /**
   * @var string
   */
  protected $currency = 'GBP';

  /**
   * @var boolean
   */
  protected $tax = true;

  /**
   * @var integer
   */
  protected $taxRate = 20;

}
```
If you would like to add your region to Merchant:
* Open a Pull Request
* Create a new class for your region under `src\Philipbrown\Merchant\Region`
* Make sure your class extends `AbstractRegion` and implements `RegionInterface`

### Money and Currency
Money and Currency in Merchant is abstracted to [Money](https://github.com/philipbrown/money). For full details, usage and documentation please see that repository.

Briefly:
* Values are represented as integers to avoid the floating point problem
* Objects are immutable
* Currency details are encapsulated in it's own class

### Creating a new Merchant instance
To create a new Merchant instance to work with, simply pass the `Region` you want to create to the `order` method:

```php
$o = Merchant::order('England');
```

### Adding a product
Adding a product to your order is as simple as specifying a [SKU](http://en.wikipedia.org/wiki/Stock_keeping_unit) and the value of the product as an integer:

```php
$o->add('123', 1000);
```

The values for tax (if applicable) as well as the correct `Currency` instance will automatically be handled for you from the `Region` you specified when you created the Merchant instance.

The `add` method also accepts a third optional parameter of either an `array` or a `closure`. The third parameter allows you to perform actions on the product such as setting a discount, making this particular product not taxable, a freebie or setting a coupon:

```php
// Using an array
$o->add('456', 1000, array(
  'discount' => 200,
  'coupon' => 'SUMMERSALE2014'
));

// Using a closure
$o->add('789', 1000, function($item){
  $item->taxable(false);
  $item->quantity(10);
});
```

### Removing a product
To remove a product simply pass the `sku` to the `remove` method:
```php
$o->remove('456');
```

### Updating a product
When you update a product, first the product instance is removed and then replaced with the new data that you pass:
```php
// Add product with a discount
$o->add('123', 1000, array(
  'discount' => 200
));

$o->total_value->cents; // 1000
$o->total_discount->cents; // 200

// Update the product to a lower price without a discount
$o->update('123', 800);

$o->total_value->cents; // 800
$o->total_discount->cents; // 200
```

### Order totals
As you add, update or remove products from your order Merchant will be automatically calculating the various totals that you will need to record in your database and display on reciepts and invoices. Each total is an instance of `Money`:
```php
$o->add('123', 1000);
$o->add('456', 200, array(
  'freebie' => true
));
$o->add('789', 2000, array(
  'discount' => 500
));
$o->add('101112', 1000, array(
  'taxable' => false
));

// Total value of the products (before freebies/discounts/tax)
$o->total_value->cents; // 4200

// Total discount for all products with discounts
$o->total_discount->cents; // 500

// Total tax for taxable products
$o->total_tax->cents; // 500

// Subtotal of all products (before discounts/tax)
$o->subtotal->cents; // 4000

// Total of all products (including discounts/tax)
$o->total->cents; // 4000
```

### Future developments
Currently Merchant does not deal with any physical attributes of selling online. For example, delivery charges, international shipping etc, etc, etc.

I have no plans to add any of these attributes as I don't have the requirment. If you do and you want to extend Merchant, feel free to open a Pull Request.

## License
The MIT License (MIT)

Copyright (c) 2013 Philip Brown

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
