<?php namespace PhilipBrown\Merchant\Transformers;

use DomDocument;
use PhilipBrown\Merchant\Order;
use PhilipBrown\Merchant\Converter;
use PhilipBrown\Merchant\Transformer;

class XMLTransformer implements Transformer
{
    /**
     * @var Converter
     */
    private $converter;

    /**
     * Create a new JSONTransformer
     *
     * @param Converter $converter
     * @return void
     */
    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Transform the Order
     *
     * @param Order $order
     * @return mixed
     */
    public function transform(Order $order)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');

        foreach ($order->totals() as $key => $total) {
            $element = $dom->createElement($key, $this->converter->convert($total));
            $dom->appendChild($element);
        }

        $products = $dom->createElement('products');

        $dom->appendChild($products);

        return $dom->saveXML();
    }
}
