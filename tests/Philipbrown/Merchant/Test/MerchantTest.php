<?php namespace Philipbrown\Merchant\Test;

use Philipbrown\Merchant\Merchant;

class MerchantTest extends TestCase {

  public function testInstantiateValidRegion()
  {
    $m = new Merchant;
    $m->create('England');
  }

  /**
   * @expectedException        Philipbrown\Merchant\Exception\InvalidRegionException
   * @expectedExceptionMessage Nuh huh is not a valid region
   */
  public function testExceptionOnInvalidRegion()
  {
    $m = new Merchant;
    $m->create('Nuh huh');
  }

}
