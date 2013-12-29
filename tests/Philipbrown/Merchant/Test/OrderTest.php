<?php namespace Philipbrown\Merchant\Test;

use Philipbrown\Merchant\Merchant;

class OrderTest extends TestCase {

  public function testAddProductToOrder()
  {
    $o = Merchant::order('England');
    $o->add('123', 999);
    $this->assertCount(1, $o->products);
    $this->assertEquals('123', $o->products[0]->sku);
    $this->assertEquals(999, $o->products[0]->value->cents);
    $this->assertEquals('GBP', $o->products[0]->currency);
    $this->assertTrue($o->products[0]->taxable);
    $this->assertEquals(20, $o->products[0]->tax_rate);
    $this->assertEquals(200, $o->products[0]->tax->cents);
    $this->assertEquals(1, $o->products[0]->quantity);
  }

  public function testRemoveProductFromProductsList()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000);
    $this->assertTrue($o->remove('123'));
    $this->assertEquals(0, count($o->products));
  }

  /**
   * @expectedException        Philipbrown\Merchant\Exception\InvalidOrderException
   * @expectedExceptionMessage sss was not found in the products list
   */
  public function testRemoveNotFoundProductFromProductsListException()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000);
    $this->assertTrue($o->remove('sss'));
  }

  public function testUpdateProductFromProductsList()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, function($product){
      $product->discount(200);
    });
    $this->assertEquals(1000, $o->products[0]->value->cents);
    $this->assertEquals(200, $o->products[0]->discount->cents);
    $this->assertEquals(1, count($o->products));

    $o->update('123', 800);
    $this->assertEquals(800, $o->products[0]->value->cents);
    $this->assertEquals(0, $o->products[0]->discount->cents);
    $this->assertEquals(1, count($o->products));
  }

  /**
   * @expectedException        Exception
   * @expectedExceptionMessage fff is not a valid property on this object
   */
  public function testInvalidPropertyThroughMagicMethodException()
  {
    $o = Merchant::order('England');
    $o->fff;
  }

}
