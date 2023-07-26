<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TwoFailed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cubicle;
    public $manager;
    public $eid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cubicle, $manager, $eid)
    {
        $this->cubicle = $cubicle;
        $this->manager = $manager;
        $this->eid = $eid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('call-board');
    }

    public function broadcastWith() 
    {
        return [
            'cubicle' => $this->cubicle->id,
            'manager' => $this->manager,
            'eid' => $this->eid,
        ];
    }
}
