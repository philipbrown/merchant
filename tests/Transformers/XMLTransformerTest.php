<?php namespace PhilipBrown\Merchant\Tests;

use PhilipBrown\Merchant\Order;
use PhilipBrown\Merchant\Converter;
use PhilipBrown\Merchant\Processor;
use PhilipBrown\Merchant\Fixtures\BasketFixture;
use PhilipBrown\Merchant\Transformers\XMLTransformer;
use PhilipBrown\Merchant\Reconcilers\UnitedKingdomReconciler;

use PhilipBrown\Merchant\Calculators\ValueCalculator;

class XMLTransformerTest extends \PHPUnit_Framework_TestCase
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

        $this->processor   = new Processor($reconciler, [
            new ValueCalculator($reconciler)
        ]);

        $this->transformer = new XMLTransformer(new Converter('en_GB'));
    }

    /** @test */
    public function should_transform_basket_to_xml()
    {
        $order = $this->processor->process($this->fixtures->zero());

        $output = $this->transformer->transform($order);

        var_dump($output);
    }
}
