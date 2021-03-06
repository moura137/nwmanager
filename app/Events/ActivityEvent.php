<?php

namespace NwManager\Events;

use NwManager\Events\Event;
use NwManager\Entities\Activity;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActivityEvent extends Event implements ShouldBroadcast
{
    /**
     * @var Activity
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
     * @param Activity $activity
     *
     * @return void
     */
    public function __construct(Activity $activity)
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
        return $this->activity->presenter()['data'];
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
