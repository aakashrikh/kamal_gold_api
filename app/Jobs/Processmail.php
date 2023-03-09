<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Mail;
class Processmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $mail;
    public function __construct($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data=$this->mail;
        try{

            Mail::send($data['template'], $data['data'], function($message)use ($data) {
                $message->to($data['to'])->subject
                    ($data['subject']);
                $message->from($data['from'] ,$data['from_name']);
            });
        }
        catch(\Exception $e){
            return $e->getMessage();
        }

    }
}
