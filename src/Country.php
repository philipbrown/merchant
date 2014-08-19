<?php namespace PhilipBrown\Merchant;

interface Country {

  /**
   * Return the currency
   *
   * @return Money\Currency
   */
  public function currency();

  /**
   * Return the Tax Rate
   *
   * @return PhilipBrown\Merchant\TaxRate
   */
  public function tax();

}
