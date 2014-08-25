<?php

use PhilipBrown\Merchant\String;

class StringTest extends PHPUnit_Framework_TestCase {

  /** @test */
  public function should_convert_to_snake_case()
  {
    $this->assertEquals('this_should_be_snaked', String::snake('ThisShouldBeSnaked'));
  }

}
