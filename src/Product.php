<?php namespace PhilipBrown\Merchant;

use Money\Money;

class Product {

  use Gettable;

  /**
   * @var string
   */
  private $sku;

  /**
   * @var string
   */
  private $name;

  /**
   * @var Money\Money
   */
  private $price;

  /**
   * @var TaxRate
   */
  private $rate;

  /**
   * @var int
   */
  private $quantity;

  /**
   * @var bool
   */
  private $freebie;

  /**
   * @var bool
   */
  private $taxable;

  /**
   * @var Collection
   */
  private $coupons;

  /**
   * @var Collection
   */
  private $tags;

  /**
   * Create a new Product
   *
   * @param string $sku
   * @param string $name
   * @param Money $price
   * @param TaxRate $rate
   */
  public function __construct($sku, $name, Money $price, TaxRate $rate)
  {
    $this->sku      = $sku;
    $this->name     = $name;
    $this->price    = $price;
    $this->rate     = $rate;
    $this->quantity = 1;
    $this->freebie  = false;
    $this->taxable  = true;
    $this->coupons  = new Collection;
    $this->tags     = new Collection;
  }

  /**
   * Increment the quantity
   *
   * @return void
   */
  public function increment()
  {
    $this->quantity++;
  }

  /**
   * Decrement of the quantity
   *
   * @return void
   */
  public function decrement()
  {
    $this->quantity--;
  }

  /**
   * Set the freebie status
   *
   * @param Status $status
   * @return void
   */
  public function freebie(Status $status)
  {
    $this->freebie = $status->value;
  }

  /**
   * Set the taxable status
   *
   * @param Status $status
   * @return void
   */
  public function taxable(Status $status)
  {
    $this->taxable = $status->value;
  }

}
