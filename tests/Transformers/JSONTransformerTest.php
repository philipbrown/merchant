<?php namespace PhilipBrown\Merchant;

use PhilipBrown\Merchant\Order;
use PhilipBrown\Merchant\Transformers\JSONTransformer;

class JSONTransformerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Order */
    private $order;

    /** @var Transformer */
    private $transformer;

    public function setUp()
    {
        $this->order = new Order([], []);
        $this->transformer = new JSONTransformer;
    }

    /** @test */
    public function should_transform_to_json()
    {
        $payload = $this->transformer->transform($this->order);

        $this->assertTrue(is_object(json_decode($payload)));
    }
}
