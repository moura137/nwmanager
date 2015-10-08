<?php

namespace NwManager\Events;

use NwManager\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActivityEvent extends Event implements ShouldBroadcast
{
    /**
     * @var mixed
     */
    protected $activity;

    /**
     * @var string
     */
    protected $channelName = 'activities';

    /**
     * @var string
     */
    protected $eventName = 'ActivityEvent';

    /**
     * Create a new event instance.
     *
     * @param mixed $activity
     *
     * @return void
     */
    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [$this->channelName];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return $this->activity->presenter();
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
