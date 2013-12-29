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

  public function testCorrectTotalValueProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000);
    $o->add('456', 800);
    $this->assertEquals(1800, $o->total_value->cents);
    $o->add('789', 2000);
    $this->assertEquals(3800, $o->total_value->cents);
    $o->remove('456');
    $this->assertEquals(3000, $o->total_value->cents);
  }

  public function testCorrectTotalDiscountProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'discount' => 200
    ));
    $o->add('456', 1200, array(
      'discount' => 100
    ));
    $this->assertEquals(300, $o->total_discount->cents);
    $o->remove('123');
    $this->assertEquals(100, $o->total_discount->cents);
  }

  public function testCorrectTotalTaxProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000);
    $o->add('456', 800);
    $o->add('789', 2000, array(
      'taxable' => false
    ));
    $this->assertEquals(360, $o->total_tax->cents);
  }

  public function testCorrectSubtotalProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000);
    $o->add('456', 2000, array(
      'discount' => 500
    ));
    $o->add('789', 600, array(
      'freebie' => true
    ));
    $this->assertEquals(3000, $o->subtotal->cents);
  }

  public function testCorrectTotalProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000);
    $o->add('456', 2000, array(
      'discount' => 500
    ));
    $this->assertEquals(3000, $o->total->cents);
  }

  public function testCorrectTotalsWithMultipleQuantity()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'quantity' => 5
    ));
    $this->assertEquals(5000, $o->subtotal->cents);
    $this->assertEquals(1000, $o->total_tax->cents);
    $this->assertEquals(6000, $o->total->cents);
  }

  public function testRandomData()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000);
    $o->add('456', 200, array(
      'freebie' => true
    ));
    $o->add('789', 2000, array(
      'discount' => 500
    ));
    $o->add('101112', 1000, array(
      'taxable' => false
    ));
    $this->assertEquals(4200, $o->total_value->cents);
    $this->assertEquals(500, $o->total_discount->cents);
    $this->assertEquals(500, $o->total_tax->cents);
    $this->assertEquals(4000, $o->subtotal->cents);
    $this->assertEquals(4000, $o->total->cents);
  }

}
