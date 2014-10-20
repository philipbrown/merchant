<?php namespace PhilipBrown\Merchant\Listeners;

use League\Event\EventInterface;
use League\Event\AbstractListener;
use PhilipBrown\Merchant\Listener;

class RemoveZeroQuantityProductsFromList extends AbstractListener
{
    /**
     * Handle an Event
     *
     * @param EventInterface $event
     * @return void
     */
    public function handle(EventInterface $event)
    {
        foreach ($event->products() as $sku => $product) {
            if (! $product->quantity) {
                $event->products()->remove($sku);
            }
        }
    }
}
