<?php

namespace NwManager\Events;

use NwManager\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotifyEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $channel;

    /**
     * @var string
     */
    protected $eventName = 'NotifyEvent';

    /**
     * Create a new event instance.
     *
     * @param mixed  $data
     * @param string $string
     *
     * @return void
     */
    public function __construct($channel, $data)
    {
        $this->data = $data;
        $this->channel = $channel;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [$this->channel];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['data' => $this->data];
    }

    /**
     * Get Event Name
     *
     * @return string
     */
    public function broadcastAs()
    {
        return $this->eventName;
    }
}
