<?php namespace PhilipBrown\Merchant;

class String {

  /**
   * Convert a string to snake case
   *
   * @param string $value
   * @return string
   */
  public static function snake($value)
  {
    return ctype_lower($value) ? $value : strtolower(preg_replace('/(.)([A-Z])/', '$1_$2', $value));
  }

}
