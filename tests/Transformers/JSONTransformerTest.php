<?php namespace PhilipBrown\Merchant\Tests;

use PhilipBrown\Merchant\Order;
use PhilipBrown\Merchant\Converter;
use PhilipBrown\Merchant\Processor;
use PhilipBrown\Merchant\Fixtures\BasketFixture;
use PhilipBrown\Merchant\Transformers\JSONTransformer;
use PhilipBrown\Merchant\Reconcilers\UnitedKingdomReconciler;

class JSONTransformerTest extends \PHPUnit_Framework_TestCase
{
    /** @var BasketFixture */
    private $fixtures;

    /** @var Processor */
    private $processor;

    /** @var Transformer */
    private $transformer;

    public function setUp()
    {
        $reconciler      = new UnitedKingdomReconciler;
        $this->fixtures  = new BasketFixture;

        $this->processor   = new Processor($reconciler);

        $this->transformer = new JSONTransformer(new Converter('en_GB'));
    }

    /** @test */
    public function should_transform_basket_to_json()
    {
        $order = $this->processor->process($this->fixtures->zero());

        $output = $this->transformer->transform($order);

        $this->assertTrue(is_object(json_decode($output)));
    }
}
