<?php namespace PhilipBrown\Merchant;

use PhilipBrown\Money\Money;
use PhilipBrown\Merchant\RegionInterface;
use PhilipBrown\Merchant\Exception\InvalidOrderException;

class Order extends Helper {

  /**
   * The region of the Order
   *
   * @var RegionInterface
   */
  protected $region;

  /**
   * The products of the order
   *
   * @var array
   */
  protected $products;

  /**
   * The cache of the products for easy lookups
   *
   * @var array
   */
  protected $products_cache;

  /**
   * The total value of the order
   *
   * @var Money
   */
  protected $total_value;

  /**
   * The total discount of the order
   *
   * @var Money
   */
  protected $total_discount;

  /**
   * The total tax of the order
   *
   * @var Money
   */
  protected $total_tax;

  /**
   * The subtotal of the order
   *
   * @var Money
   */
  protected $subtotal;

  /**
   * The total of the order
   *
   * @var Money
   */
  protected $total;

  /**
   * Does the order need to be reconciled?
   *
   * @var boolean
   */
  protected $dirty;

  /**
   * Create a new Order
   *
   * @param RegionInterface $region
   * @return void
   */
  public function __construct(RegionInterface $region)
  {
    $this->region = $region;
    $this->dirty = true;
  }

  /**
   * Add a product to the order
   *
   * @param string $sku
   * @param integer $value
   * @param Closure|array $action
   * @return boolean
   */
  public function add($sku, $value, $action = null)
  {
    $product = new Product(
      $sku,
      $value,
      $this->region->currency,
      $this->region->tax,
      $this->region->taxRate
    );

    if(!is_null($action)) $product->action($action);

    $this->products[] = $product;

    $this->products_cache[] = $sku;

    $this->dirty = true;

    return true;
  }

  /**
   * Remove a product from the order
   *
   * @param string $sku
   * @return boolean
   */
  public function remove($sku)
  {
    if(in_array($sku, $this->products_cache))
    {
      $key = array_search($sku, $this->products_cache);

      unset($this->products[$key]);
      unset($this->products_cache[$key]);

      $this->products = array_values($this->products);
      $this->products_cache = array_values($this->products_cache);

      $this->dirty = true;

      return true;
    }

    throw new InvalidOrderException("$sku was not found in the products list");
  }

  /**
   * Update an existing product
   *
   * @param string $sku
   * @param integer $value
   * @param Closure|array $action
   */
  public function update($sku, $value, $action = null)
  {
    if($this->remove($sku))
    {
      $product = new Product(
        $sku,
        $value,
        $this->region->currency,
        $this->region->tax,
        $this->region->taxRate
      );

      if(!is_null($action)) $product->action($action);

      $this->products[] = $product;

      $this->products_cache[] = $sku;

      $this->dirty = true;

      return true;
    }
  }

  /**
   * Reconcile the order if it is dirty
   *
   * @return void
   */
  public function reconcile()
  {
    if($this->dirty)
    {
      $total_value = 0;
      $total_discount = 0;
      $total_tax = 0;
      $subtotal = 0;

      foreach($this->products as $product)
      {
        $i = $product->quantity;

        while($i > 0)
        {
          $total_value = $total_value + $product->value->cents;
          $total_discount = $total_discount + $product->discount->cents;
          $total_tax = $total_tax + $product->tax->cents;
          $subtotal = $subtotal + $product->total->cents;
          $i--;
        }
      }

      $this->total_value = Money::init($total_value, $this->region->currency);
      $this->total_discount = Money::init($total_discount, $this->region->currency);
      $this->total_tax = Money::init($total_tax, $this->region->currency);
      $this->subtotal = Money::init(($subtotal), $this->region->currency);
      $this->total = Money::init(($subtotal - $this->total_discount->cents + $this->total_tax->cents), $this->region->currency);

      $this->dirty = false;
    }
  }

  /**
   * Get the total parameter
   *
   * @return Money
   */
  protected function getTotalValueParameter()
  {
    $this->reconcile();

    return $this->total_value;
  }

  /**
   * Get the total discount parameter
   *
   * @return Money
   */
  protected function getTotalDiscountParameter()
  {
    $this->reconcile();

    return $this->total_discount;
  }

  /**
   * Get the total tax parameter
   *
   * @return Money
   */
  protected function getTotalTaxParameter()
  {
    $this->reconcile();

    return $this->total_tax;
  }

  /**
   * Get the subtotal parameter
   *
   * @return Money
   */
  protected function getSubtotalParameter()
  {
    $this->reconcile();

    return $this->subtotal;
  }

  /**
   * Get the total parameter
   *
   * @return Money
   */
  protected function getTotalParameter()
  {
    $this->reconcile();

    return $this->total;
  }

  /**
   * Get the region parameter
   *
   * @return string
   */
  protected function getRegionParameter()
  {
    return $this->region;
  }

  /**
   * Get the products parameter
   *
   * @return array
   */
  protected function getProductsParameter()
  {
    return $this->products;
  }

}
