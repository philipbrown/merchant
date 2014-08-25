<?php namespace PhilipBrown\Merchant;

class Reconciler {

  /**
   * @var array
   */
  private $totals;

  /**
   * Create a new Reconciler
   *
   * @param array $totals
   * @return void
   */
  public function __construct(array $totals)
  {
    $this->totals = $totals;
  }

  /**
   * Reconcile a Basket
   *
   * @param Basket $basket
   * @return Order
   */
  public function reconcile(Basket $basket)
  {
    return new Order(new Collection, new Collection);
  }

}

