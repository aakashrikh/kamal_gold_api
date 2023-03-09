<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\AppHelper;
use App\Models\Notification;
use App\Events\NotificationChannel;
class ProcessPush implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
	Protected $heading;
	Protected $url;
	Protected $user_id;
	Protected $user_type;
	Protected $desc;
    public function __construct($heading,$url,$user_id,$user_type,$desc)
    {
        $this->heading=$heading;
		$this->url=$url;
		if(is_array($user_id))
		{
			$this->user_id=$user_id;
		}
		else{
			$this->user_id[0]['user_id']=$user_id;
		}
		$this->user_type=$user_type;
		$this->desc=$desc;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
			$data=array();
			foreach($this->user_id as $user)
			{
				$id=$user['user_id'];
				$data[] =
				[
					'notification_title'=>$this->heading,
					'notification_url'=>$this->url,
					'notification_description'=>$this->desc,
					'receiver_type'=>$this->user_type,
					'received_id'=>$id,
				];

				$rs['title']=$this->heading;
				$rs['url']=$this->url;
				$rs['desc']=$this->desc;
				$rs['user_type']=$this->user_type;
				$rs['user_id']=$id;

				if($this->user_type == 'vendor')
				{
					event(new NotificationChannel($rs));
				}
				//request to send push to App
				AppHelper::send_Push($this->heading,$this->url,$this->user_type,$id,$this->desc);
			}

			//insert notification in DB
			Notification::insert($data);


    }
}
