<?php namespace PhilipBrown\Merchant\Listeners;

use PhilipBrown\Merchant\Event;
use PhilipBrown\Merchant\Listener;

class RemoveZeroQuantityProductsFromList implements Listener
{
    /**
     * Handle an Event
     *
     * @param Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        foreach ($event->products() as $sku => $product) {
            if (! $product->quantity) {
                $event->products()->remove($sku);
            }
        }
    }
}
