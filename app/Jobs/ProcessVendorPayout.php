<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\vendor_txn_log;
use App\Models\Vendor;
use App\Models\vendor_payout_account;
use Razorpay\Api\Api;
use App\Helpers\AppHelper;
class ProcessVendorPayout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $vendor_id;
	protected $txn_amount;
	protected $order_code;
    protected $payment_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vendor_id,$txn_amount,$order_code,$payment_id)
    {
         $this->vendor_id = $vendor_id;
		 $this->txn_amount = $txn_amount;
		 $this->order_code = $order_code;
         $this->payment_id = $payment_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$vendor_id=$this->vendor_id;
		$order_id=$this->order_code;
		$txn_amount=$this->txn_amount;

        $bal=vendor_txn_log::where('vendor_id',$vendor_id)->where('txn_type','credit')->sum('txn_amount')-vendor_txn_log::where('vendor_id',$vendor_id)->where('txn_type','debit')->sum('txn_amount');

        if($bal>0)
        {
            $payout=vendor_payout_account::where('vendor_id',$vendor_id)->where('payout_account_status','active')->get();

            if(count($payout)>0)
            {
                $fund_id=$payout[0]->payout_account_id;

                $transfer_charge=($txn_amount*2/100)+(($txn_amount*2/100)*18/100);

                $transfer_amount= (int) (round($txn_amount-$transfer_charge,2));
                if($transfer_amount>1)
                {
                    $vt=new vendor_txn_log();
                    $vt->txn_amount=$txn_amount;
                    $vt->txn_id=$order_id;
                    $vt->txn_type='debit';
                    $vt->txn_status='processing';
                    $vt->txn_comment='debit for order-'.$order_id;
                    $vt->vendor_id=$vendor_id;

                    if($vt->save())
                    {

                        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
                        try
                        {

                            $result=$api->payment->fetch($this->payment_id)->transfer(array('transfers' => array(array('account' => $fund_id,'amount' =>$transfer_amount*100,'currency' => 'INR','on_hold' => 0))));
                             $vt_id=$vt->id;
                            // $ch = curl_init();
                            // $Params = array(
                            // "account_number" => env('RAZORPAY_ACCOUNT_NO'),
                            // "fund_account_id" => $fund_id,
                            // "amount"     => $transfer_amount*100,
                            // "currency"	    => "INR",
                            // "mode"     => "IMPS",
                            // "purpose"	    => "payout",
                            // "queue_if_low_balance"     => true,
                            // "reference_id"	    => $order_id,
                            //  "narration"=> "testing",
                            // );

                            // $post_data = json_encode($Params, JSON_UNESCAPED_SLASHES);

                            // curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payouts');
                            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            // curl_setopt($ch, CURLOPT_POST, 1);
                            // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                            // curl_setopt($ch, CURLOPT_USERPWD, env('RAZORPAY_KEY') . ':' . env('RAZORPAY_SECRET'));

                            // $headers = array();
                            // $headers[] = 'Content-Type: application/json';
                            // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                            //  $result = json_decode(curl_exec($ch));

                            if(isset($result['error']))
                            {

                                $vv=vendor_txn_log::find($vt_id);
                                $vt->txn_status='failed';
                                $vt->txn_comment="failed by gateway";
                                $vt->save();
                            }
                            else
                            {
                                //$payout_id=$result->id;

                                $vv=vendor_txn_log::find($vt_id);
                                $vt->txn_status='success';
                                $vt->txn_comment="payout id - ".$order_id;

                                if($vt->save())
                                {
                                    //update vendor_wallet
                                    $vendor=Vendor::find($vendor_id);
                                    $vendor->wallet=$vendor->wallet-$txn_amount;
                                    $vendor->save();

                                        //send notification to vendor
                                    $heading_user= "Payout Received of Rs.".$txn_amount;
                                    $post_url=env('NOTIFICATION_VENDOR_URL')."/ViewTransaction/";

                                    //request to send push to App
                                    AppHelper::send_Push($heading_user,$post_url,'vendor',$vendor_id,'');

                                }
                            }

                        }
                        catch(\Exception $e)
                        {
                            return $e->getMessage();
                        }
                    }

                }
            }
        }
    }
}
