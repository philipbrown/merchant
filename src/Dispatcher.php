<?php namespace PhilipBrown\Merchant;

class Dispatcher {

  /**
   * @var array
   */
  private $listeners = [];

  /**
   * Add a Listener to an event
   *
   * @param string $event
   * @param Listener $listener
   * @return void
   */
  public function listen($event, Listener $listener)
  {
    $this->listeners[$event][] = function() use ($listener)
    {
      call_user_func_array([$listener, 'handle'], func_get_args());
    };
  }

  /**
   * Fire an event
   *
   * @param string $event
   * @param array $payload
   * @return void
   */
  public function fire($event, array $payload = [])
  {
    foreach ($this->findListenersForEvent($event) as $listener)
    {
      call_user_func_array($listener, $payload);
    }
  }

  /**
   * Find Listeners for event
   *
   * @param string $event
   * @return array
   */
  private function findListenersForEvent($event)
  {
    if(isset($this->listeners[$event]))
    {
      return $this->listeners[$event];
    }

    return [];
  }

}
