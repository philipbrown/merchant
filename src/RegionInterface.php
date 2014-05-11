<?php namespace PhilipBrown\Merchant;

interface RegionInterface {

  /**
   * Get Name
   *
   * @return string
   */
  public function getNameParameter();

  /**
   * Get Currency
   *
   * @return string
   */
  public function getCurrencyParameter();

  /**
   * Get Tax
   *
   * @return boolean
   */
  public function getTaxParameter();

  /**
   * Get Tax Rate
   *
   * @return integer
   */
  public function getTaxRateParameter();

}
