<?php namespace PhilipBrown\Merchant;

class Order {

  /**
   * @var Collection
   */
  private $totals;

  /**
   * @var Collection
   */
  private $products;

  /**
   * Create a new Order
   *
   * @param Collection $totals
   * @param Collection $products
   */
  public function __construct(Collection $totals, Collection $products)
  {
    $this->totals   = $totals;
    $this->products = $products;
  }

  /**
   * Get the totals collection
   *
   * @return Collection
   */
  public function totals()
  {
    return $this->totals;
  }

  /**
   * Get the products collection
   *
   * @return Collection
   */
  public function products()
  {
    return $this->products;
  }

}
