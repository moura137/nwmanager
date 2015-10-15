<?php

namespace NwManager\Events;

use NwManager\Events\Event;
use NwManager\Entities\ProjectTask;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewTaskEvent extends Event implements ShouldBroadcast
{
    /**
     * @var ProjectTask
     */
    protected $task;

    /**
     * @var string
     */
    protected $channelName = 'activities';

    /**
     * @var string
     */
    protected $eventName = 'NewTaskEvent';

    /**
     * Create a new event instance.
     *
     * @param ProjectTask $task
     *
     * @return void
     */
    public function __construct(ProjectTask $task)
    {
        $this->task = $task;
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
        return $this->task->presenter()['data'];
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
