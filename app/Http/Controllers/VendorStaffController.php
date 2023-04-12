<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\vendor_staff_account;
use App\Models\user_vendor_feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\UserOrders;
use App\Models\user_order_product;
use App\Helpers\AppHelper;
use App\Models\user_orders_txn_log;
use App\Events\KotstatusChannel;
use App\Models\Vendor;
use App\Jobs\Processmail;
class VendorStaffController extends Controller
{
    //add staff account

    public function add_staff(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'staff_name' => 'required',
            'staff_contact' => 'required',
            'staff_role' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $password = Hash::make($request->password);
        $staff = new vendor_staff_account;
        $staff->staff_name = $request->staff_name;
        $staff->staff_contact = $request->staff_contact;
        $staff->password = $password;
        $staff->staff_role = $request->staff_role;
        $staff->staff_account_status = 'active';
        $staff->id = Auth::user()->id;

        $email=Vendor::find(Auth::user()->id)->email;
        if($staff->save())
        {
            $mail['from']=env('MAIL_FROM_ADDRESS');
            $mail['from_name']='Weazy Dine Alerts';

            $mail['to']=$email;
            $mail['subject']='A new staff account has been added to your account.';

            $mail['data']=array('staff_name'=>$request->staff_name, 'contact_no'=>$request->staff_contact,'account_role'=>$request->staff_role,'ip_address'=>$request->ip(),'time'=>date('Y-m-d H:i:s'),'browser'=>$request->header('User-Agent'));
            $mail['template']='emails.new_staff';

            if($email != null)
            {
                Processmail::dispatch($mail);
            }


            $response['status']=true;
            $response['data']=$staff;
        }
        else
        {
            $response['status']=false;
            $response['data']='Something went wrong';
        }
        return response()->json($response);
    }

    //fetch staff account

    public function fetch_staff(Request $request)
    {
        $staff = vendor_staff_account::where('id', Auth::user()->id)->get();

        if(count($staff) > 0)
        {
            $response['status']=true;
            $response['data']=$staff;
        }
        else
        {
            $response['status']=false;
            $response['data']='No data found';
        }
        return response()->json($response);
    }

    //fetch staff account by id

    public function fetch_staff_account_by_id(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $staff = vendor_staff_account::where('staff_id', $request->staff_id)->where('id', Auth::user()->id)->get();

        if(count($staff) > 0)
        {
            $response['status']=true;
            $response['data']=$staff;
        }
        else
        {
            $response['status']=false;
            $response['data']='No data found';
        }
        return response()->json($response);
    }

    //update staff account

    public function update_staff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'staff_name' => 'required',
            'staff_role' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $staff = vendor_staff_account::where('staff_id', $request->staff_id)->where('id', Auth::user()->id)->first();
        $staff->staff_name = $request->staff_name;
        $staff->staff_role = $request->staff_role;
        $staff->id = Auth::user()->id;

        if($staff->save())
        {
            $response['status']=true;
            $response['msg']="Staff account updated successfully";
        }
        else
        {
            $response['status']=false;
            $response['msg']='Something went wrong';
        }
        return response()->json($response);
    }


    //delete staff account

    public function delete_staff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $staff = vendor_staff_account::where('staff_id', $request->staff_id)->where('id', Auth::user()->id)->where('staff_role','!=','owner')->delete();

        if($staff)
        {
            $response['status']=true;
            $response['data']='Staff account deleted successfully';
        }
        else
        {
            $response['status']=false;
            $response['data']='Something went wrong';
        }
        return response()->json($response);
    }

    public function update_kot_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kot_id' => 'required',
            'order_id' => 'required',
            'status' => 'required',
            'message' => 'required_if:status,!=,declined',
            'prepare_time'=>'required_if:status,==,in_process',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $vendor_id=Auth::user()->id;
        $estimate_time=$request->prepare_time;

        $new_time = date('Y-m-d H:i:s', strtotime('+'.$estimate_time.' minutes', strtotime(date('Y-m-d H:i:s'))));

       // $data=UserOrders::where('order_code',$request->order_id)->where('vendor_id',$vendor_id)->update(['order_status'=>$request->status,'estimate_prepare_time'=>$new_time]);
       $order_id=$request->order_id;

        user_order_product::where('kot',$request->kot_id)->where('order_id',function($q)use($order_id){
            $q->select('id')->from('user_orders')->where('order_code',$order_id);
        })->where('order_product_status','!=','processed')->update(['order_product_status'=>$request->status,'kot_status'=>$request->status]);

        if($request->status == 'in_process')
        {
            UserOrders::where('order_code',$request->order_id)->where('vendor_id',$vendor_id)->update(['order_status'=>$request->status,'estimate_prepare_time'=>$new_time]);
        }


        //update order status whene the all kot processed

        if($request->status == 'processed')
        {


            //fetch order

            $order=UserOrders::where('order_code',$order_id)->where('vendor_id',$vendor_id)->first();

            if($order->order_type == 'Delivery' || $order->order_type == 'TakeAway')
            {
                $order_status='completed';
            }
            else
            {
                $order_status='processed';
            }

            $kot_count=user_order_product::where('order_id',function($q) use ($order_id)
            {
                $q->select('id')->from('user_orders')->where('order_code',$order_id);
            })->where('order_product_status','!=','processed')->count();

            if($kot_count == 0)
            {
                UserOrders::where('order_code',$request->order_id)->where('vendor_id',$vendor_id)->update(['order_status'=>$order_status]);
            }
        }

        KotstatusChannel::dispatch($vendor_id);
        $response['status']=true;
        $response['msg']='Status updated successfully';
        return response()->json($response);
    }


    public function get_staff_data(Request $request)
    {
        $vendor_id=Auth::user()->staff_id;
        $shop_id=Auth::user()->id;

        if(isset($request->range))
        {
            $range=$request->range;
            if($request->range == 'custom')
            {
                $from=date("Y-m-d 00:00:00", strtotime($request->from));
                $to=date("Y-m-d 23:59:59",strtotime($request->to));
            }
            else{
                $date_range=AppHelper::get_date_range($request->range);
                $from=$date_range['from'];
                $to=$date_range['to'];
            }
        }
        else
        {
            $from = date("Y-m-d 00:00:00");
			$to = date("Y-m-d 23:59:59");
        }

 		$response['orders']=UserOrders::where('staff_id',$vendor_id)->whereNotIn('order_status',['failed','cancelled'])->whereBetween('created_at', [$from, $to])->count('id');

//        $response['followers']=Vendors_Subsciber::where('vendor_id',$vendor_id)->count();

        $response['total_earnning']=user_orders_txn_log::whereIn('order_id',function($q) use($vendor_id,$shop_id){
            $q->select('id')->from('user_orders')->where('staff_id',$vendor_id)->where('vendor_id',$shop_id);
        })->where('txn_status','success')->whereBetween('created_at', [$from, $to])->sum('txn_amount');


        $response['cashsale']=user_orders_txn_log::whereIn('order_id',function($q) use($vendor_id){
            $q->from('user_orders')
            ->selectRaw('id')
            ->where('staff_id',$vendor_id);
        })->where('txn_method','Cash')->where('txn_status','success')->whereBetween('created_at', [$from, $to])->sum('txn_amount');

        $response['weazypay']=user_orders_txn_log::whereIn('order_id',function($q) use($vendor_id){
            $q->from('user_orders')
            ->selectRaw('id')
            ->where('staff_id',$vendor_id);
        })->where('txn_channel','online')->where('txn_status','success')->whereBetween('created_at', [$from, $to])->sum('txn_amount');

        $response['online']=user_orders_txn_log::whereIn('order_id',function($q) use($vendor_id){
            $q->from('user_orders')
            ->selectRaw('id')
            ->where('staff_id',$vendor_id);
        })->where('txn_channel','offline')->where('txn_method','!=','Cash')->whereBetween('created_at', [$from, $to])->where('txn_status','success')->sum('txn_amount');

        $data=user_orders_txn_log::with('orders')->whereIn('order_id',function($q) use($vendor_id){
            $q->from('user_orders')
            ->selectRaw('id')
            ->where('staff_id',$vendor_id);
        })->whereBetween('created_at', [$from, $to])->where('txn_status','success')->paginate(100);

        $response['status']=true;
        $response['data']=$data;
        return json_encode($response);
    }


    public function get_orders_staff(Request $request)
    {
		$vendor_id=Auth::user()->staff_id;
		if(isset($request->status) && $request->status != '')
		{
			$status=$request->status;
			$data=UserOrders::with('user')->with('table')->where('staff_id',$vendor_id)->where('order_status',$status)->orderBy('id','DESC')->paginate(20);
		}
		else
		{
			$data=UserOrders::with('user')->with('table')->where('order_status','!=','failed')->where('staff_id',$vendor_id)->orderBy('id','DESC')->paginate(20);
		}


        if(count($data)>0)
        {
            $response['status']=true;
            $response['data']=$data;
        }
        else
        {
            $response['status']=false;
            $response['data']="Order ID is not valid";
        }
        return   json_encode($response,JSON_UNESCAPED_SLASHES);

    }
}
