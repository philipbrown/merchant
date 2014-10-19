<?php namespace PhilipBrown\Merchant\Transformers;

use PhilipBrown\Merchant\Order;
use PhilipBrown\Merchant\Converter;
use PhilipBrown\Merchant\Transformer;

class JSONTransformer implements Transformer
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
        $payload = ['products' => []];

        foreach ($order->totals() as $key => $total) {
            $payload[$key] = $this->converter->convert($total);
        }

        foreach ($order->products() as $product) {
            $payload['products'] = array_map(function ($value) {
                return $this->converter->convert($value);
            }, $product);
        }

        return json_encode($payload);
    }
}
