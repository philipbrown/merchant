<?php namespace PhilipBrown\Merchant;

interface Total {

  /**
   * Run calculation
   *
   * @param Basket $basket
   * @return mixed
   */
  public function calculate(Basket $basket);

  /**
   * Get the name of the Total
   *
   * @return string
   */
  public function name();

}
