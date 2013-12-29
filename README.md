# Merchant
**Ecommerce abstract for dealing with products, orders and sales**

[![Build Status](https://travis-ci.org/philipbrown/merchant.png?branch=master)](https://travis-ci.org/philipbrown/merchant)

Merchant is a simply abstraction for working with products, orders and sales within an ecommerce application. It aims to solve the problem of dealing with multiple product orders and the associated data that you will be required to store and use within the lifecycle of a customer.

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
