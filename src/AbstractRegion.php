<?php namespace PhilipBrown\Merchant;

abstract class AbstractRegion extends Helper {

  /**
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $currency;

  /**
   * @var boolean
   */
  protected $tax;

  /**
   * @var integer
   */
  protected $taxRate;

  /**
   * Get Name
   *
   * @return string
   */
  public function getNameParameter()
  {
    return $this->name;
  }

  /**
   * Get Currency
   *
   * @return string
   */
  public function getCurrencyParameter()
  {
    return $this->currency;
  }

  /**
   * Get Tax
   *
   * @return boolean
   */
  public function getTaxParameter()
  {
    return $this->tax;
  }

  /**
   * Get Tax Rate
   *
   * @return integer
   */
  public function getTaxRateParameter()
  {
    return $this->taxRate;
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->getNameParameter();
  }

}
