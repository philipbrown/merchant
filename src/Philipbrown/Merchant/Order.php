<?php namespace Philipbrown\Merchant;

use Philipbrown\Money\Money;
use Philipbrown\Merchant\RegionInterface;
use Philipbrown\Merchant\Exception\InvalidOrderException;

class Order extends Helper {

  /**
   * @var RegionInterface
   */
  protected $region;

  /**
   * @var array
   */
  protected $products;

  /**
   * @var array
   */
  protected $products_cache;

  /**
   * @var Money
   */
  protected $total_value;

  /**
   * @var Money
   */
  protected $total_discount;

  /**
   * @var Money
   */
  protected $total_tax;

  /**
   * @var Money
   */
  protected $subtotal;

  /**
   * Construct
   *
   * @param RegionInterface $region
   */
  public function __construct(RegionInterface $region)
  {
    $this->region = $region;
  }

  /**
   * Add
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

    return true;
  }

  /**
   * Update
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

      return true;
    }
  }

  /**
   * Remove
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
      return true;
    }

    throw new InvalidOrderException("$sku was not found in the products list");
  }

  /**
   * Reconcile
   */
  public function reconcile()
  {
    $total_value = 0;
    $total_discount = 0;
    $total_tax = 0;

    foreach($this->products as $product)
    {
      $total_value = $total_value + $product->value->cents;
      $total_discount = $total_discount + $product->discount->cents;
      $total_tax = $total_tax + $product->tax->cents;
    }

    $this->total_value = Money::init($total_value, $this->region->currency);
    $this->total_discount = Money::init($total_discount, $this->region->currency);
    $this->total_tax = Money::init($total_tax, $this->region->currency);
    $this->subtotal = Money::init(($this->total_value->cents), $this->region->currency);
  }

  /**
   * Get Total Parameter
   *
   * @return Money
   */
  protected function getTotalValueParameter()
  {
    $this->reconcile();

    return $this->total_value;
  }

  /**
   * Get Total Discount
   *
   * @return Money
   */
  protected function getTotalDiscountParameter()
  {
    $this->reconcile();

    return $this->total_discount;
  }

  /**
   * Get Total Tax
   *
   * @return Money
   */
  protected function getTotalTaxParameter()
  {
    $this->reconcile();

    return $this->total_tax;
  }

  /**
   * Get Subtotal
   *
   * @return Money
   */
  protected function getSubtotalParameter()
  {
    $this->reconcile();

    return $this->subtotal;
  }

  /**
   * Get Region
   *
   * @return string
   */
  protected function getRegionParameter()
  {
    return $this->region;
  }

  /**
   * Get Products
   *
   * @return array
   */
  protected function getProductsParameter()
  {
    return $this->products;
  }

}
