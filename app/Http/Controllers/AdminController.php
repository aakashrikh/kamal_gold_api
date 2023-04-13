<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\scheme;
use App\Models\user_scheme;
use App\Models\user_scheme_emi;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Helpers\AppHelper;
use Illuminate\Support\Str;
class AdminController extends Controller
{
	//method for contact verification


    public function get_pending_payment(Request $request)
    {
       $data= user_scheme_emi::with('scheme')->where('emi_date','<=',date('Y-m-d'))->where('emi_status','pending')->get();

         if($data)
         {
                return response()->json(['status' => true, 'message' => 'Pending payment list','data'=>$data]);
         }
         else
         {
                return response()->json(['status' => false, 'message' => 'No pending payment']);
         }
    }

    public function get_collection(Request $request)
    {
        $data= user_scheme_emi::with(['scheme','staff'])->where('emi_status','paid')->orderBy('updated_at','DESC')->get();

         if($data)
         {
                return response()->json(['status' => true, 'message' => 'Collection list','data'=>$data]);
         }
         else
         {
                return response()->json(['status' => false, 'message' => 'No collection']);
         }
    }

    public function get_dashboard_data(Request $request)
    {
        $response['total_customer']=User::where('status','!=','deleted')->count();
        $response['pending_verification']=0;
        $response['scheme']=scheme::where('status','!=','deleted')->count();
        $response['month_collection']=user_scheme_emi::where('emi_status','paid')->whereMonth('updated_at',date('m'))->sum('emi_amount');
        $response['active_scheme']=user_scheme::where('scheme_status','active')->count();
        $response['completed_scheme']=user_scheme::where('scheme_status','completed')->count();

        $response['user']=Auth::user();
        $response['status']=true;
        return json_encode($response);
    }
    public function add_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required',
            'dob'=>'required',
            'email' => 'required',
            'father_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $user = User::where('contact', $request->mobile)->first();
        if ($user) {
            return response()->json(['status' => false, 'message' => 'Contact already exist']);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['status' => false, 'message' => 'Email already exist']);
        }
        $password = Hash::make(Str::random(8));

        $user = new User();
        $user->name = $request->name;
        $user->contact = $request->mobile;
        // $user->address = $request->address;
        $user->dob = $request->dob;
        $user->father_name = $request->father_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->whatsapp=$request->whatsapp_number;
        $user->status = 'active';
       if($user->save())
       {
            return response()->json(['status' => true, 'message' => 'Customer added successfully']);
        }
       else
       {
            return response()->json(['status' => false, 'message' => 'Something went wrong']);
       }

    }

    //method for update customer

    public function update_customer(Request $request)
    {
        // return $request->name;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'contact' => 'required',
            'dob'=>'required',
            // 'address' => 'required',
            'email' => 'required',
            // 'password' => 'required',
            'father_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

       $dd=$request->name;
        // $name=$request->name;

        $user = User::find($request->id);
        $user->name = $dd;
        $user->contact = $request->contact;
        // $user->address = $request->address;
        $user->dob = $request->dob;
        $user->father_name = $request->father_name;
        $user->email = $request->email;
        $user->whatsapp=$request->whatsapp_number;
        // $user->password = Hash::make($request->password);
        // $user->status = $request->status;
        $user->save();

        return response()->json(['status' => true, 'message' => 'Customer updated successfully']);
    }

    //method for delete customer

    public function delete_customer(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $user = User::find($request->id);
        $user->status='deleted';
        $user->save();


        return response()->json(['status' => true, 'message' => 'Customer deleted successfully']);
    }

    //method for get customer

    public function get_customer(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $user = User::find($request->id);

        return response()->json(['status' => true, 'message' => 'Customer get successfully','data'=>$user]);
    }

    //method for get all customer

    public function customer_list(Request $request)
    {

        $user = User::where('status','!=','deleted')->get();

        return response()->json(['status' => true, 'message' => 'Customer get successfully','data'=>$user]);
    }

    //method for add scheme

    public function add_scheme(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'scheme_name' => 'required',
            'scheme_amount' => 'required',
            'emi'=>'required',
            // 'scheme_emi_date' => 'required',
            'scheme_length' => 'required',
            'final_receive' => 'required',
            'terms' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $scheme = new scheme();
        $scheme->scheme_name = $request->scheme_name;
        $scheme->scheme_amount  = $request->scheme_amount;
        $scheme->scheme_emi  = $request->emi;
        // $scheme->scheme_emi_date = $request->scheme_emi_date;
        $scheme->scheme_length  = $request->scheme_length;
        $scheme-> final_receive  = $request->final_receive;
        $scheme->term_condition = $request->terms;
        $scheme->status = 'active';
        $scheme->save();

        return response()->json(['status' => true, 'message' => 'Scheme added successfully']);
    }

    //method for update scheme

    public function update_scheme(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'scheme_name' => 'required',
            'scheme_amount' => 'required',
            'scheme_emi'=>'required',
            'scheme_emi_date' => 'required',
            'scheme_length' => 'required',
            'final_receive' => 'required',
            'term_condition' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $scheme = scheme::find($request->id);
        $scheme->scheme_name = $request->scheme_name;
        $scheme->scheme_amount  = $request->scheme_amount;
        $scheme->scheme_emi  = $request->scheme_emi;
        $scheme->scheme_emi_date = $request->scheme_emi_date;
        $scheme->scheme_length  = $request->scheme_length;
        $scheme-> final_receive  = $request->final_receive;
        $scheme->term_condition = $request->term_condition;
        $scheme->save();

        return response()->json(['status' => true, 'message' => 'Scheme updated successfully']);
    }

    //method for delete scheme

    public function delete_scheme(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $scheme = scheme::find($request->id);
        $scheme->status='deleted';
        $scheme->save();

        return response()->json(['status' => true, 'message' => 'Scheme deleted successfully']);
    }

    //method for get scheme


    public function scheme_list(Request $request)
    {

        $scheme = scheme::withCount('customer')->where('status','!=','deleted')->get();

        return response()->json(['status' => true, 'message' => 'Scheme get successfully','data'=>$scheme]);

    }


    public function add_scheme_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'scheme_id' => 'required',
            'customer_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $scheme_id=$request->scheme_id;
        $customer_id=$request->customer_id;
        $scheme=scheme::find($scheme_id);

        $scheme_length=$scheme->scheme_length;
        $scheme_emi=$scheme->scheme_emi;

        $us=new user_scheme();
        $us->scheme_id=$scheme_id;
        $us->user_id=$customer_id;
        $us->scheme_status='active';

        if($us->save())
        {
            $id=$us->id;

            $data = array();

            for($i=1;$i<=$scheme_length;$i++)
            {
                $data[] = array(
                    'user_scheme_id' => $id,
                    'emi_amount' => $scheme_emi,
                    'emi_date' => date('Y-m-d', strtotime('+'.$i.' month')),
                    'emi_status' => 'pending',
                );
            }

            user_scheme_emi::insert($data);

            $response['status']=true;
            $response['message']='Scheme added successfully';
        }
        else
        {
            $response['status']=false;
            $response['message']='Something went wrong';
        }

        return response()->json($response);
    }


    public function add_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required',
            'emi_date' => 'required',
            'payment_method'=>'required',
            'invoice_id'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $emi_id=$request->payment_id;
        $payment_date=$request->emi_date;
        $payment_method=$request->payment_method;
        
        $remark=$request->remark;
        $invoice_id=$request->invoice_id;

        $emi=user_scheme_emi::find($emi_id);
        $emi->emi_status='paid';
        $emi->payment_method=$payment_method;
        $emi->remark=$remark;
        $emi->payment_date=$payment_date;
        $emi->invoice_id=$invoice_id;
        
        $emi->staff_id=Auth::user()->staff_id;

        $user_scheme_id=$emi->user_scheme_id;
        if($emi->save())
        {
            //fetch pending payments

            $pending_payments=user_scheme_emi::where('user_scheme_id',$user_scheme_id)->where('emi_status','pending')->count();

            if($pending_payments==0)
            {
                $us=user_scheme::find($user_scheme_id);
                $us->scheme_status='completed';
                $us->save();
            }

            $vendor_id=Auth::user()->id;
            $vendor=Vendor::find($vendor_id);
    
            $vendor->last_invoice=$vendor->last_invoice+1;
            $vendor->save();
            
        }


        return response()->json(['status' => true, 'message' => 'Payment added successfully']);
    }

    public function fetch_invoice(Request $request)
    {
        //vendor_id

        $vendor_id=Auth::user()->id;
        $vendor=Vendor::find($vendor_id);

        $invoice=$vendor->last_invoice+1;

        $response['status']=true;
        $response['data']=$vendor->invoice_prifix.$invoice;

        return json_encode($response);
    }

    public function fetch_schemes(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $type=$request->type;
        $schemes=user_scheme::with(['user','scheme','last'])->withCount(['paid','unpaid'])->where('scheme_status',$type)->get();

        $response['status']=true;
        $response['data']=$schemes;

        return json_encode($response);
    }

    public function undo_transaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        $type=$request->id;

        $emi=user_scheme_emi::find($type);
        $emi->emi_status='pending';
        $emi->payment_method='';
        $emi->remark='';
        $emi->payment_date='';
        $emi->invoice_id='';
        $emi->staff_id=0;
        $emi->save();

        $response['status']=true;
        $response['message']='Transaction undo successfully';

        return json_encode($response);

    }

}
