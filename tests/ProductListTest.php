<?php

use PhilipBrown\Merchant\ProductList;

class ProductListTest extends PHPUnit_Framework_TestCase {

  /** @test ProductList */
  private $list;

  public function setUp()
  {
    $this->list = new ProductList([1,2,3]);
  }

  /** @test */
  public function can_get_all_items()
  {
    $this->assertEquals([1,2,3], $this->list->all());
  }

  /** @test */
  public function can_get_item_by_id()
  {
    $this->assertEquals(2, $this->list->get(1));
  }

  /** @test */
  public function can_put_an_item_in_the_list()
  {
    $this->list->put(3, 4);

    $this->assertEquals(4, $this->list->get(3));
  }

  /** @test */
  public function can_count_the_items_in_the_list()
  {
    $this->assertEquals(3, $this->list->count());
  }

  /** @test */
  public function can_remove_an_item_from_a_list()
  {
    $this->list->remove(0);

    $this->assertFalse($this->list->contains(0));
  }

  /** @test */
  public function can_check_for_item()
  {
    $this->assertTrue($this->list->contains(0));
  }

}
