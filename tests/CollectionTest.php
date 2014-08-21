<?php

use PhilipBrown\Merchant\Collection;

class CollectionTest extends PHPUnit_Framework_TestCase {

  /** @var array */
  private $items = ['Homer', 'Marge', 'Bart', 'Lisa', 'Maggie'];

  /** @var PhilipBrown\Merchant\Collection */
  private $collection;

  public function setUp()
  {
    $this->collection = new Collection($this->items);
  }

  /** @test */
  public function should_get_all_items()
  {
    $this->assertEquals($this->items, $this->collection->all());
  }

  /** @test */
  public function should_get_item_by_key()
  {
    $this->assertEquals('Lisa', $this->collection->get(3));
  }

  /** @test */
  public function should_add_item()
  {
    $this->collection->add('cat', 'Snowball II');

    $this->assertEquals('Snowball II', $this->collection->get('cat'));
  }

  /** @test */
  public function should_remove_item()
  {
    $this->collection->remove(0);

    $this->assertEquals(4, $this->collection->count());
  }

  /** @test */
  public function should_check_for_item()
  {
    $this->assertTrue($this->collection->contains('Bart'));
  }

  /** @test */
  public function should_count_items()
  {
    $this->assertEquals(5, $this->collection->count());
  }

  /** @test */
  public function should_get_first_item()
  {
    $this->assertEquals('Homer', $this->collection->first());
  }

  /** @test */
  public function should_get_last_item()
  {
    $this->assertEquals('Maggie', $this->collection->last());
  }

  /** @test */
  public function should_push_item_onto_the_end()
  {
    $this->collection->push("Santa's Little Helper");

    $this->assertEquals(6, $this->collection->count());
    $this->assertEquals("Santa's Little Helper", $this->collection->get(5));
  }

}
