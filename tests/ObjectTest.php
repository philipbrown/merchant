<?php

use PhilipBrown\Merchant\Object;

class ObjectTest extends PHPUnit_Framework_TestCase {

    /** @test */
    public function should_get_properties()
    {
        $object = new Object(['hello' => 'world']);

        $this->assertEquals('world', $object->hello);
    }

}
