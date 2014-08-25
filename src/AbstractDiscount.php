<?php namespace PhilipBrown\Merchant;

abstract class AbstractDiscount {

  /**
   * Return the value of the Discount
   *
   * @return mixed
   */
  public function value()
  {
    return $this->discount;
  }

}
