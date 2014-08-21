# Merchant
**Ecommerce abstraction for dealing with products, orders and sales**

Merchant is a simple abstraction for working with products, orders and sales within an ecommerce application. It aims to solve the problem of dealing with multiple product orders and the associated data that you will be required to store and use within the lifecycle of a customer.

## tl;dr

## Money and Currency
Dealing with Money and Currency in an ecommerce application can be fraught with difficulties. Instead of passing around dump values, we can use Value Objects that are immuatable and protects the invariant of the items we hope to represent.

This package uses [mathiasverraes/money](https://github.com/mathiasverraes/money) by [@mathiasverraes](https://github.com/mathiasverraes) throughout to represent Money and Currency values.

For further details on how to use these objects, I would recommend taking a look at that repository.

## Tax Rates
In order to correctly calculate the total value of a transaction and the associated tax we need a way to represent the tax rate that should be applied.

For example the included `TaxRates\UnitedKingdomValueAddedTax` represent the tax rate of the United Kingdom.

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

