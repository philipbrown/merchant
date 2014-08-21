<?php namespace PhilipBrown\Merchant;

use Countable;
use ArrayIterator;
use IteratorAggregate;

class Collection implements Countable, IteratorAggregate {

  /**
   * @var array
   */
  private $items;

  /**
   * Create a new Collection instance
   *
   * @param array $items
   * @return void
   */
  public function __construct(array $items = [])
  {
    $this->items = $items;
  }

  /**
   * Get all the items of the Collection
   *
   * @return array
   */
  public function all()
  {
    return $this->items;
  }

  /**
   * Get an item from the Collection by key
   *
   * @param mixed $key
   * @return mixed
   */
  public function get($key)
  {
    return $this->items[$key];
  }

  /**
   * Add a new item by key
   *
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public function add($key, $value)
  {
    $this->items[$key] = $value;
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
   * Check to see if a value is in the Collection
   *
   * @param mixed $value
   * @return bool
   */
  public function contains($value)
  {
    return in_array($value, $this->items);
  }

  /**
   * Count the number of items in the Collection
   *
   * @return int
   */
  public function count()
  {
    return count($this->items);
  }

  /**
   * Get the first item of the Collection
   *
   * @return mixed
   */
  public function first()
  {
    return reset($this->items);
  }

  /**
   * Get the last item of hte Collection
   *
   * @return mixed
   */
  public function last()
  {
    return end($this->items);
  }

  /**
   * Push an item onto the end of the Collection
   *
   * @param mixed $value
   * @return void
   */
  public function push($value)
  {
    $this->items[] = $value;
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
