<?php namespace PhilipBrown\Merchant;

class Dispatcher
{
    /**
     * @var array
     */
    private $listeners;

    /**
     * Add a Listener
     *
     * @param string $name
     * @param Listener $listenr
     * @return void
     */
    public function add($name, Listener $listener)
    {
        $this->listeners[$name][] = $listener;
    }

    /**
     * Return the registered Listeners for a given Event name
     *
     * @param string $name
     * @return array
     */
    public function registered($name)
    {
        if (isset($listeners[$name])) {
            return $listeners[$name];
        }

        return [];
    }

    /**
     * Fire an Event
     *
     * @param array $event
     * @return void
     */
    public function fire(array $events)
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    /**
     * Dispatch the Event to each Listener
     *
     * @param Event $event
     * @return void
     */
    private function dispatch(Event $event)
    {
        foreach ($this->registered($event->name) as $listener) {
             $listener->handle($event);
        }
    }
}
