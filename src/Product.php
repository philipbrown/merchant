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
   * Set the quantity
   *
   * @param Quantity $quantity
   * @return void
   */
  public function quantity(Quantity $quantity)
  {
    $this->quantity = $quantity->value;
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

  /**
   * Add a coupon
   *
   * @param string $coupon
   * @return void
   */
  public function coupon($coupon)
  {
    $this->coupons->push($coupon);
  }

  /**
   * Add a tag
   *
   * @param string $tag
   * @return void
   */
  public function tag($tag)
  {
    $this->tags->push($tag);
  }

  /**
   * Set the Tax Rate
   *
   * @param PhilipBrown\Merchant\TaxRate
   * @return void
   */
  public function rate(TaxRate $rate)
  {
    $this->rate = $rate;
  }

  /**
   * Set a discount
   *
   * @return void
   */
  public function discount(Discount $discount)
  {
    $this->discount = $discount;
  }

}
