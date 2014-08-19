<?php namespace PhilipBrown\Merchant;

interface TaxRate {

  /**
   * Return the rate as an float
   *
   * @return int
   */
  public function asFloat();

  /**
   * Return the rate as a percentage
   *
   * @return float
   */
  public function asPercentage();

}
