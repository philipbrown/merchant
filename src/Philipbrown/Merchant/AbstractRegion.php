<?php namespace Philipbrown\Merchant;

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
  protected function getNameParameter()
  {
    return $this->name;
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
   * Get Tax
   *
   * @return boolean
   */
  protected function getTaxParameter()
  {
    return $this->tax;
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
   * @return string
   */
  public function __toString()
  {
    return $this->getNameParameter();
  }

}
