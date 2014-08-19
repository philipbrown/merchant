<?php namespace PhilipBrown\Merchant;

use Countable;
use ArrayIterator;
use IteratorAggregate;

class ProductList implements Countable, IteratorAggregate {

  /**
   * The items contained in the list
   *
   * @var array
   */
  protected $items = [];

  /**
   * Create a new ProductList
   *
   * @param array $items
   * @return void
   */
  public function __construct(array $items = [])
  {
    $this->items = $items;
  }

  /**
   * Get all of the items in the list
   *
   * @return array
   */
  public function all()
  {
    return $this->items;
  }

  /**
   * Get an item from the list by key
   *
   * @param mixed $key
   * @param mixed $default
   * @return mixed
   */
  public function get($key)
  {
    if (array_key_exists($key, $this->items))
    {
      return $this->items[$key];
    }
  }

  /**
   * Add an item to the list by key
   *
   * @param mixed $key
   * @param mixed $value
   * @return void
   */
  public function put($key, $value)
  {
    $this->items[$key] = $value;
  }

  /**
   * Count the number of items in the list
   *
   * @return int
   */
  public function count()
  {
    return count($this->items);
  }

  /**
   * Remove an item from the list by key
   *
   * @param mixed $key
   * @return void
   */
  public function remove($key)
  {
    unset($this->items[$key]);
  }

  /**
   * Check to see if a key is in the list
   *
   * @param mixed $key
   * @return mixed $value
   */
  public function contains($key)
  {
    return isset($this->items[$key]);
  }

  /**
   * Get an iterator for the items
   *
   * @return \ArrayIterator
   */
  public function getIterator()
  {
    return new ArrayIterator($this->items);
  }

}
