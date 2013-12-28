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
    $m->create('Nuh huh');
  }

  public function testInstantiateValidRegion()
  {
    $o = Merchant::create('England');
    $this->assertInstanceOf('Philipbrown\Merchant\Order', $o);
    $this->assertInstanceOf('Philipbrown\Merchant\RegionInterface', $o->region);
    $this->assertEquals('England', $o->region);
    $this->assertEquals('GBP', $o->region->currency);
    $this->assertTrue($o->region->hasTax());
    $this->assertEquals(20, $o->region->tax_rate);
  }

  public function testAddProductsToOrder()
  {
    $o = Merchant::create('England');
    $o->add('123', 123);
    $this->assertCount(1, $o->products);
  }

}
