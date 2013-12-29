<?php namespace Philipbrown\Merchant\Test;

use Philipbrown\Merchant\Merchant;

class MerchantTest extends TestCase {

  /**
   * @expectedException        Philipbrown\Merchant\Exception\InvalidRegionException
   * @expectedExceptionMessage Nuh huh is not a valid region
   */
  public function testExceptionOnInvalidRegion()
  {
    $m = new Merchant;
    $m->order('Nuh huh');
  }

  public function testInstantiateValidRegion()
  {
    $o = Merchant::order('England');
    $this->assertInstanceOf('Philipbrown\Merchant\Order', $o);
    $this->assertInstanceOf('Philipbrown\Merchant\RegionInterface', $o->region);
    $this->assertEquals('England', $o->region);
    $this->assertEquals('GBP', $o->region->currency);
    $this->assertTrue($o->region->tax);
    $this->assertEquals(20, $o->region->tax_rate);
  }

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
    $this->assertEquals(0, $o->products[0]->value->cents);
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
    $this->assertEquals(0, $o->products[0]->value->cents);
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

}
