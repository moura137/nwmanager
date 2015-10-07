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
    protected $channel = 'feed-activity';

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
        return [$this->channel];
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

    public function broadcastAs()
    {
        return 'ActivityEvent';
    }
}
