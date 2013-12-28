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
   * @var boolean
   */
  protected $tax;

  /**
   * @var integer
   */
  protected $taxRate;

  /**
   * Get Name
   *
   * @return string
   */
  protected function getNameParameter()
  {
    return $this->name;
  }

  /**
   * Get Currency
   *
   * @return string
   */
  protected function getCurrencyParameter()
  {
    return $this->currency;
  }

  /**
   * Has Tax?
   *
   * @return boolean
   */
  public function hasTax()
  {
    return $this->tax;
  }

  /**
   * Get Tax Rate
   *
   * @return integer
   */
  protected function getTaxRateParameter()
  {
    return $this->taxRate;
  }

  /**
   * Convert a string to camelcase
   *
   * e.g hello_world -> helloWorld
   *
   * @param string $str
   * @return string
   */
  public static function camelise($str)
  {
    return preg_replace_callback('/_([a-z0-9])/', function ($m) {
        return strtoupper($m[1]);
      },
      $str
    );
  }

  /**
   * __get Magic Method
   *
   * @return mixed
   */
  public function __get($param)
  {
    $method = 'get'.ucfirst(self::camelise($param)).'Parameter';

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
