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
    $m = new Merchant;
    $o = $m->create('England');
    $this->assertInstanceOf('Philipbrown\Merchant\Order', $o);
    $this->assertInstanceOf('Philipbrown\Merchant\RegionInterface', $o->region);
    $this->assertEquals('England', $o->region);
    $this->assertEquals('GBP', $o->region->currency);
  }

}
