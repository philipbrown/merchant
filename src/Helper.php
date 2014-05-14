<?php namespace PhilipBrown\Merchant;

use Exception;

abstract class Helper {

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

    if(method_exists($this, $method)) return $this->{$method}();

    throw new Exception("$param is not a valid property on this object");
  }

}
