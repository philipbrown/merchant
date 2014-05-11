<?php namespace PhilipBrown\Merchant;

interface RegionInterface {

  /**
   * Get the name of the region
   *
   * @return string
   */
  public function getNameParameter();

  /**
   * Get the currency of the region
   *
   * @return string
   */
  public function getCurrencyParameter();

  /**
   * Check to see if tax is set in this region
   *
   * @return bool
   */
  public function getTaxParameter();

  /**
   * Get the tax rate of the region
   *
   * @return int
   */
  public function getTaxRateParameter();

}
