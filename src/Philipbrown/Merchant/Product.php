<?php namespace Philipbrown\Merchant;

class Product extends Helper {

  /**
   * @var string
   */
  protected $sku;

  /**
   * @var integer
   */
  protected $value;

  /**
   * Construct
   *
   * @param string $sku
   * @param integer $value
   * @param Closure|array $action
   */
  public function __construct($sku, $value, $action)
  {
    $this->sku = $sku;

    // Perform action

    $this->value = $value;
  }

  /**
   * Get SKU
   *
   * @return string
   */
  protected function getSkuParameter()
  {
    return $this->sku;
  }

}
