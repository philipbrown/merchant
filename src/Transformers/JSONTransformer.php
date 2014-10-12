<?php namespace PhilipBrown\Merchant\Transformers;

use PhilipBrown\Merchant\Order;
use PhilipBrown\Merchant\Transformer;

class JSONTransformer implements Transformer
{
    /**
     * Transform the Order
     *
     * @param Order $order
     * @return mixed
     */
    public function transform(Order $order)
    {
        return json_encode($order->toArray());
    }
}
