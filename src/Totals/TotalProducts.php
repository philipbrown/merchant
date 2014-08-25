<?php namespace PhilipBrown\Merchant\Totals;

use PhilipBrown\Merchant\Total;
use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\AbstractTotal;

class TotalProducts extends AbstractTotal implements Total {

  /**
   * Run calculation
   *
   * @param Basket $basket
   * @return int
   */
  public function calculate(Basket $basket)
  {
    return $basket->count();
  }

}
