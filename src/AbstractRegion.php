<?php namespace PhilipBrown\Merchant;

abstract class AbstractRegion extends Helper {

  /**
   * The name of the region
   *
   * @var string
   */
  protected $name;

  /**
   * The currency of the region
   *
   * @var string
   */
  protected $currency;

  /**
   * Does this region have tax?
   *
   * @var bool
   */
  protected $tax;

  /**
   * The tax rate of the region
   *
   * @var integer
   */
  protected $taxRate;

  /**
   * Get the name of the region
   *
   * @return string
   */
  public function getNameParameter()
  {
    return $this->name;
  }

  /**
   * Get the currency of the region
   *
   * @return string
   */
  public function getCurrencyParameter()
  {
    return $this->currency;
  }

  /**
   * Check to see if tax is set in this region
   *
   * @return bool
   */
  public function getTaxParameter()
  {
    return $this->tax;
  }

  /**
   * Get the tax rate of the region
   *
   * @return integer
   */
  public function getTaxRateParameter()
  {
    return $this->taxRate;
  }

  /**
   * Return the region as a string
   *
   * @return string
   */
  public function __toString()
  {
    return $this->getNameParameter();
  }

}
