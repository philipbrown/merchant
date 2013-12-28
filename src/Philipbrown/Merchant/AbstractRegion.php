<?php namespace Philipbrown\Merchant;

abstract class AbstractRegion {

  /**
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $currency;

  /**
   * Get Name
   *
   * @return string
   */
  public function getNameParameter()
  {
    return $this->name;
  }

  /**
   * Get Currency
   *
   * @return string
   */
  public function getCurrencyParameter()
  {
    return $this->currency;
  }

  /**
   * __get Magic Method
   *
   * @return mixed
   */
  public function __get($param)
  {
    $method = 'get'.ucfirst($param).'Parameter';

    if(method_exists($this, $method))

    return $this->{$method}();
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->getNameParameter();
  }

}
