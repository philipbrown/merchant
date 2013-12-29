<?php namespace Philipbrown\Merchant;

use Closure;
use Philipbrown\Money\Money;
use Philipbrown\Merchant\Exception\InvalidProductException;

class Product extends Helper {

  /**
   * @var string
   */
  protected $sku;

  /**
   * @var string
   */
  protected $currency;

  /**
   * @var Money
   */
  protected $value;

  /**
   * @var boolean
   */
  protected $taxable;

  /**
   * @var integer
   */
  protected $taxRate;

  /**
   * @var Money
   */
  protected $tax;

  /**
   * @var Money
   */
  protected $discount;

  /**
   * @var integer
   */
  protected $quantity;

  /**
   * @var boolean
   */
  protected $freebie;

  /**
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
    $this->value = Money::init($value, $currency);
    $this->currency = $currency;
    $this->taxable = $taxable;
    $this->taxRate = $taxRate;
    $this->discount = Money::init(0, $currency);
    $this->tax = ($taxable) ? $this->value->multiply(($taxRate / 100)) : Money::init(0, $currency);
    $this->quantity = 1;
    $this->freebie = false;
  }

  /**
   * Action
   *
   * @param Closure|array $action
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

    throw new InvalidProductException;
  }

  /**
   * Run Action Array
   *
   * @param array $action
   */
  protected function runActionArray(array $action)
  {
    foreach($action as $k => $v)
    {
      $method = 'set'.ucfirst(self::camelise($k)).'Parameter';

      if(method_exists($this, $method))

      $this->{$method}($v);
    }
  }

  /**
   * Run Action Closure
   *
   * @param Closure $action
   */
  protected function runActionClosure($action)
  {
    call_user_func($action, $this);
  }

  /**
   * Quantity
   *
   * @param integer $value
   */
  public function quantity($value)
  {
    $this->setQuantityParameter($value);
  }

  /**
   * Set Quantity Parameter
   *
   * @param integer $value
   */
  protected function setQuantityParameter($value)
  {
    if(is_int($value))
    {
      $this->quantity = $value;
    }
  }

  /**
   * Taxable
   *
   * @param boolean $value
   */
  public function taxable($value)
  {
    $this->setTaxableParameter($value);
  }

  /**
   * Set Taxable Parameter
   *
   * @param boolean $value
   */
  protected function setTaxableParameter($value)
  {
    if(is_bool($value))
    {
      $this->taxable = $value;
      $this->tax = ($this->taxable) ? $this->value->multiply(($this->taxRate / 100)) : Money::init(0, $this->currency);
    }
  }

  /**
   * Discount
   *
   * @param integer $value
   */
  public function discount($value)
  {
    $this->setDiscountParameter($value);
  }

  /**
   * Set Discount Parameter
   *
   * @param integer $value
   */
  protected function setDiscountParameter($value)
  {
    if(is_int($value))
    {
      $this->discount = Money::init($value, $this->currency);
    }
  }

  /**
   * Freebie
   *
   * @param boolean $value
   */
  public function freebie($value)
  {
    $this->setFreebieParameter($value);
  }

  /**
   * Set Freebie Parameter
   *
   * @param boolean $value
   */
  protected function setFreebieParameter($value)
  {
    if(is_bool($value))
    {
      $this->freebie = $value;
      $this->value = ($this->freebie) ? Money::init(0, $this->currency) : $this->value;
      $this->tax = ($this->freebie) ? Money::init(0, $this->currency) : $this->tax;
      $this->taxable = ($this->freebie) ? false : $this->taxable;
      $this->discount = ($this->freebie) ? Money::init(0, $this->currency) : $this->discount;
    }
  }

  /**
   * Coupon
   *
   * @param string $value
   */
  public function coupon($value)
  {
    $this->setCouponParameter($value);
  }

  /**
   * Set Coupon Parameter
   *
   * @param string $value
   */
  protected function setCouponParameter($value)
  {
    if(is_string($value))
    {
      $this->coupon = $value;
    }
  }

  /**
   * Get SKU
   *
   * @return string
   */
  protected function getSkuParameter()
  {
    return $this->sku;
  }

  /**
   * Get Currency
   *
   * @return string
   */
  protected function getCurrencyParameter()
  {
    return $this->currency;
  }

  /**
   * Get Value
   *
   * @return integer
   */
  protected function getValueParameter()
  {
    return $this->value;
  }

  /**
   * Get Taxable
   *
   * @return boolean
   */
  protected function getTaxableParameter()
  {
    return $this->taxable;
  }

  /**
   * Get Tax Rate
   *
   * @return integer
   */
  protected function getTaxRateParameter()
  {
    return $this->taxRate;
  }

  /**
   * Get Tax
   *
   * @return Money
   */
  protected function getTaxParameter()
  {
    return $this->tax;
  }

  /**
   * Get Quantity
   *
   * @return integer
   */
  protected function getQuantityParameter()
  {
    return $this->quantity;
  }

  /**
   * Get Discount
   *
   * @return Money
   */
  protected function getDiscountParameter()
  {
    return $this->discount;
  }

  /**
   * Get Freebie
   *
   * @return boolean
   */
  protected function getFreebieParameter()
  {
    return $this->freebie;
  }

  /**
   * Get Coupon
   *
   * @return string
   */
  protected function getCouponParameter()
  {
    return $this->coupon;
  }

}
