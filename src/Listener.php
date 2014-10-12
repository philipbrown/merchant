<?php namespace PhilipBrown\Merchant;

interface Listener
{
    /**
     * Handle an Event
     *
     * @param Event $event
     * @return void
     */
    public function handle(Event $event);
}
