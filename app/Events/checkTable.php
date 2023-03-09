<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Vendor;
class checkTable implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

	public $vendor;
    public function __construct($vendor)
    {
        $this->vendor = Vendor::find($vendor);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
		 return new PrivateChannel('checkTableStatus.'.$this->vendor->id);
    }


	public function broadcastWith()
    {

        $tables=$this->vendor->tables()->get();
        return [
            'tables' => $tables,
        ];
    }

	public function broadcastAs()
	{
    	return 'server.created';
	}
}
