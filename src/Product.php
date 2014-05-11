<?php namespace PhilipBrown\Merchant;

use Closure;
use PhilipBrown\Money\Money;
use PhilipBrown\Merchant\Exception\InvalidProductException;

class Product extends Helper {

  /**
   * The product's stock keeping unit
   *
   * @var string
   */
  protected $sku;

  /**
   * The product's currency
   *
   * @var string
   */
  protected $currency;

  /**
   * The value of the product
   *
   * @var Money
   */
  protected $value;

  /**
   * Is this product taxable?
   *
   * @var boolean
   */
  protected $taxable;

  /**
   * The tax rate of the product
   *
   * @var integer
   */
  protected $taxRate;

  /**
   * The amount of tax
   *
   * @var Money
   */
  protected $tax;

  /**
   * The value of the discount
   *
   * @var Money
   */
  protected $discount;

  /**
   * The quantity of the current product
   *
   * @var int
   */
  protected $quantity;

  /**
   * Is this product a freebie?
   *
   * @var bool
   */
  protected $freebie;

  /**
   * The coupon that is associated with this product
   *
   * @var string
   */
  protected $coupon;

  /**
   * Construct
   *
   * @param string $sku
   * @param integer $currency
   */
  public function __construct($sku, $value, $currency, $taxable, $taxRate)
  {
    $this->sku = $sku;
    $this->currency = $currency;
    $this->value = Money::init($value, $currency);
    $this->taxable = $taxable;
    $this->taxRate = $taxRate;
    $this->discount = Money::init(0, $currency);
    $this->quantity = 1;
    $this->freebie = false;
    $this->tax = $this->calculateTax();
    $this->total = $this->calculateTotal();
  }

  /**
   * Set the total depending on whether this product is a freebie
   *
   * @return Money
   */
  protected function calculateTotal()
  {
    return $this->total = ($this->freebie) ? Money::init(0, $this->currency) : $this->value;
  }

  /**
   * Calculate the tax of the product
   *
   * @return Money
   */
  protected function calculateTax()
  {
    if($this->taxable)
    {
      $total = $this->value->subtract($this->discount);

      return $total->multiply($this->taxRate / 100);
    }

    return Money::init(0, $this->currency);
  }

  /**
   * Accept an array or a Closure of actions to run on the product
   *
   * @param Closure|array $action
   * @return bool
   */
  public function action($action)
  {
    if(is_array($action))
    {
      return $this->runActionArray($action);
    }

    if($action instanceof Closure)
    {
      return $this->runActionClosure($action);
    }

    throw new InvalidProductException('The action must be an array or a closure');
  }

  /**
   * Run an array of actions
   *
   * @param array $action
   * @return bool
   */
  protected function runActionArray(array $action)
  {
    foreach($action as $k => $v)
    {
      $method = 'set'.ucfirst(self::camelise($k)).'Parameter';

      if(method_exists($this, $method)) $this->{$method}($v);
    }

    return true;
  }

  /**
   * Run a Closure of actions
   *
   * @param Closure $action
   * @return bool
   */
  protected function runActionClosure($action)
  {
    call_user_func($action, $this);

    return true;
  }

  /**
   * Quantity helper method
   *
   * @param integer $value
   * @return void
   */
  public function quantity($value)
  {
    $this->setQuantityParameter($value);
  }

  /**
   * Set the quantity parameter
   *
   * @param int $value
   * @return int
   */
  protected function setQuantityParameter($value)
  {
    if(is_int($value))
    {
      return $this->quantity = $value;
    }

    throw new InvalidProductException('The quantity property must be an integer');
  }

  /**
   * Taxable helper method
   *
   * @param boolean $value
   * @return void
   */
  public function taxable($value)
  {
    $this->setTaxableParameter($value);
  }

  /**
   * Set the taxable parameter
   *
   * @param boolean $value
   * @return Money
   */
  protected function setTaxableParameter($value)
  {
    if(is_bool($value))
    {
      $this->taxable = $value;
      return $this->tax = $this->calculateTax();
    }

    throw new InvalidProductException('The taxable property must be a boolean');
  }

  /**
   * Discount helper method
   *
   * @param integer $value
   * @return void
   */
  public function discount($value)
  {
    $this->setDiscountParameter($value);
  }

  /**
   * Set the discount parameter
   *
   * @param integer $value
   */
  protected function setDiscountParameter($value)
  {
    if(is_int($value))
    {
      $this->discount = Money::init($value, $this->currency);
      return $this->tax = $this->calculateTax();
    }

    throw new InvalidProductException('The discount property must be an integer');
  }

  /**
   * Freebie helper method
   *
   * @param boolean $value
   * @return void
   */
  public function freebie($value)
  {
    $this->setFreebieParameter($value);
  }

  /**
   * Set the freebie parameter
   *
   * @param boolean $value
   */
  protected function setFreebieParameter($value)
  {
    if(is_bool($value))
    {
      $this->freebie = $value;
      $this->taxable = ($this->freebie) ? false : $this->taxable;
      $this->tax = ($this->freebie) ? Money::init(0, $this->currency) : $this->calculateTax();
      $this->discount = ($this->freebie) ? Money::init(0, $this->currency) : $this->discount;
      return $this->calculateTotal();
    }

    throw new InvalidProductException('The freebie property must be a boolean');
  }

  /**
   * Coupon helper method
   *
   * @param string $value
   */
  public function coupon($value)
  {
    $this->setCouponParameter($value);
  }

  /**
   * Set the coupon parameter
   *
   * @param string $value
   */
  protected function setCouponParameter($value)
  {
    if(is_string($value))
    {
      return $this->coupon = $value;
    }

    throw new InvalidProductException('The coupon property must be a string');
  }

  /**
   * Get the sku parameter
   *
   * @return string
   */
  protected function getSkuParameter()
  {
    return $this->sku;
  }

  /**
   * Get currency parameter
   *
   * @return string
   */
  protected function getCurrencyParameter()
  {
    return $this->currency;
  }

  /**
   * Get the value parameter
   *
   * @return integer
   */
  protected function getValueParameter()
  {
    return $this->value;
  }

  /**
   * Get the taxable parameter
   *
   * @return boolean
   */
  protected function getTaxableParameter()
  {
    return $this->taxable;
  }

  /**
   * Get the tax rate parameter
   *
   * @return integer
   */
  protected function getTaxRateParameter()
  {
    return $this->taxRate;
  }

  /**
   * Get the tax parameter
   *
   * @return Money
   */
  protected function getTaxParameter()
  {
    return $this->tax;
  }

  /**
   * Get the quantity parameter
   *
   * @return integer
   */
  protected function getQuantityParameter()
  {
    return $this->quantity;
  }

  /**
   * Get the discount parameter
   *
   * @return Money
   */
  protected function getDiscountParameter()
  {
    return $this->discount;
  }

  /**
   * Get the freebie parameter
   *
   * @return boolean
   */
  protected function getFreebieParameter()
  {
    return $this->freebie;
  }

  /**
   * Get the coupon parameter
   *
   * @return string
   */
  protected function getCouponParameter()
  {
    return $this->coupon;
  }

}
