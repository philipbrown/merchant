<?php namespace PhilipBrown\Merchant;

interface RegionInterface {

  /**
   * Get Name
   *
   * @return string
   */
  protected function getNameParameter();

  /**
   * Get Currency
   *
   * @return string
   */
  protected function getCurrencyParameter();

  /**
   * Get Tax
   *
   * @return boolean
   */
  protected function getTaxParameter();

  /**
   * Get Tax Rate
   *
   * @return integer
   */
  protected function getTaxRateParameter();

}
