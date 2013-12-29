<?php namespace Philipbrown\Merchant\Test;

use Philipbrown\Merchant\Merchant;

class ProductTest extends TestCase {

  public function testAddProductWithActionArrayAndQuantityProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'quantity' => 2
    ));
    $this->assertEquals(2, $o->products[0]->quantity);
  }

  public function testAddProductWithActionArrayAndTaxableProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'taxable' => false
    ));
    $this->assertFalse($o->products[0]->taxable);
    $this->assertEquals(0, $o->products[0]->tax->cents);
  }

  public function testAddProductWithActionArrayAndDiscountProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'discount' => 200
    ));
    $this->assertEquals(200, $o->products[0]->discount->cents);
  }

  public function testAddProductWithActionArrayAndFreebieProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'freebie' => true
    ));
    $this->assertEquals(1000, $o->products[0]->value->cents);
    $this->assertEquals(0, $o->products[0]->total->cents);
    $this->assertEquals(0, $o->products[0]->discount->cents);
    $this->assertEquals(0, $o->products[0]->tax->cents);
    $this->assertFalse($o->products[0]->taxable);
    $this->assertTrue($o->products[0]->freebie);
  }

  public function testAddProductWithActionArrayAndMultipleProperties()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'discount' => 100,
      'quantity' => 3,
      'taxable' => false
    ));
    $this->assertEquals(100, $o->products[0]->discount->cents);
    $this->assertFalse($o->products[0]->taxable);
    $this->assertEquals(0, $o->products[0]->tax->cents);
    $this->assertEquals(3, $o->products[0]->quantity);
  }

  public function testAddProductWithActionArrayAndCouponProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'coupon' => 'SAVE_10_PERCENT'
    ));
    $this->assertEquals('SAVE_10_PERCENT', $o->products[0]->coupon);
  }

  public function testAddProductWithActionClosureAndQuantityProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, function($product)
    {
      $product->quantity(10);
    });
    $this->assertEquals(10, $o->products[0]->quantity);
  }

  public function testAddProductWithActionClosureAndTaxableProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, function($product)
    {
      $product->taxable(false);
    });
    $this->assertFalse($o->products[0]->taxable);
    $this->assertEquals(0, $o->products[0]->tax->cents);
  }

  public function testAddProductWithActionClosureAndDiscountProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, function($product)
    {
      $product->discount(200);
    });
    $this->assertEquals(200, $o->products[0]->discount->cents);
  }

  public function testAddProductWithActionClosureAndFreebieProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, function($product)
    {
      $product->freebie(true);
    });
    $this->assertEquals(1000, $o->products[0]->value->cents);
    $this->assertEquals(0, $o->products[0]->total->cents);
    $this->assertEquals(0, $o->products[0]->discount->cents);
    $this->assertEquals(0, $o->products[0]->tax->cents);
    $this->assertFalse($o->products[0]->taxable);
    $this->assertTrue($o->products[0]->freebie);
  }

  public function testAddProductWithActionClosureAndCouponProperty()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, function($product)
    {
      $product->coupon('SAVE_10_PERCENT');
    });
    $this->assertEquals('SAVE_10_PERCENT', $o->products[0]->coupon);
  }

  public function testAddProductWithActionClosureAndMultipleProperties()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, function($product)
    {
      $product->taxable(false);
      $product->discount(400);
      $product->quantity(4);
    });
    $this->assertEquals(400, $o->products[0]->discount->cents);
    $this->assertFalse($o->products[0]->taxable);
    $this->assertEquals(0, $o->products[0]->tax->cents);
    $this->assertEquals(4, $o->products[0]->quantity);
  }

  /**
   * @expectedException        Philipbrown\Merchant\Exception\InvalidProductException
   * @expectedExceptionMessage The action must be an array or a closure
   */
  public function testInvalidActionTypeException()
  {
    $o = Merchant::order('England');
    $o->add('123', 233, 'action');
  }

  /**
   * @expectedException        Philipbrown\Merchant\Exception\InvalidProductException
   * @expectedExceptionMessage The quantity property must be an integer
   */
  public function testQuantityMustBeAnInteger()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'quantity' => 'lots'
    ));
  }

  /**
   * @expectedException        Philipbrown\Merchant\Exception\InvalidProductException
   * @expectedExceptionMessage The taxable property must be a boolean
   */
  public function testTaxableMustBeABoolean()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'taxable' => 'yes'
    ));
  }

  /**
   * @expectedException        Philipbrown\Merchant\Exception\InvalidProductException
   * @expectedExceptionMessage The discount property must be an integer
   */
  public function testDiscountMustBeAnInteger()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'discount' => 'lots'
    ));
  }

  /**
   * @expectedException        Philipbrown\Merchant\Exception\InvalidProductException
   * @expectedExceptionMessage The freebie property must be a boolean
   */
  public function testFreebieMustBeABoolean()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'freebie' => 'yes'
    ));
  }

  /**
   * @expectedException        Philipbrown\Merchant\Exception\InvalidProductException
   * @expectedExceptionMessage The coupon property must be a string
   */
  public function testFreebieMustBeAString()
  {
    $o = Merchant::order('England');
    $o->add('123', 1000, array(
      'coupon' => array()
    ));
  }

}
