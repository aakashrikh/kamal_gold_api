<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Vendor;
use App\Models\UserOrders;
use App\Models\user_order_product;
class KotstatusChannel implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

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
        return new PrivateChannel('KotstatusChannel.'.$this->vendor->id);
    }

    public function broadcastWith()
    {
        $data['msg']="call";
        // $data=UserOrders::with('user')->with('table')->where('vendor_id',$this->vendor->id)->whereIn('order_status',['confirmed','in_process'])->orderByDesc('id')->get();

        // if(count($data)>0)
        // {

        //     foreach($data as $key=>$d)
        //     {
        //         $data[$key]['product']=user_order_product::with(['product','variant','addons'])->where('order_id',$d->id)->get();
        //     }

        // }

        return [
            'orders' => $data
        ];

    }

    public function broadcastAs()
    {
        return 'kot.status';
    }
}

