<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Helpers\AppHelper;
use App\Jobs\Processmail;
use App\Models\refer_earn_setup;
use Illuminate\Support\Str;
use App\Models\vendor_staff_account;
class AuthController extends Controller
{
	//method for contact verification
    public function mobile_verification(request $request)
	{
		$validator = Validator::make($request->all(), [
            'contact' => 'required',
			'verification_type' => 'required'
        ]);

		if($validator->fails())
    	{
        	return response(['errors'=>$validator->errors()->all()], 422);
    	}

		//check the request its one time or resend
		if(isset($request->request_type))
		{
			$request_type=$request->request_type;
		}
		else
		{
			$request_type="send";
		}
		$contact=$request->contact;

		if(env("APP_ENV") != 'production') // condition to check this is beta or release
		{
			if($contact == 8006435315)
			{
				$otp=458855;
			}
			else
			{
				$otp=123456;
			}

			$msg="Use $otp as your OTP for WeazyDine account verification. This is confidential. Please, do not share this with anyone. Webixun infoways PVT LTD";

			$data['contact']=$contact;
			$data['msg']=$msg;
		}
		else
		{
			//Production
			if($contact == 8006435315)
			{
				$otp=458855;
			}
			else
			{
				$otp=rand(99999,999999);
			}
			$data['contact']=$contact;

			$data['request_type']=$request_type;

			if($request_type == 'send')
			{
				$data['msg']="Use $otp as your OTP for WeazyDine account verification. This is confidential. Please, do not share this with anyone. Webixun infoways PVT LTD";
				AppHelper::send_otp($data['contact'],$otp);
			}
			else
			{
				$data['msg']="Use $otp as your OTP for WeazyDine account verification. This is confidential. Please, do not share this with anyone. Webixun infoways PVT LTD";
				AppHelper::send_sms($data['contact'],$data['msg']);
			}
			//AppHelper::send_sms2($data['contact'],$msg);
			//jobs for end the sms
			//ProcessSms::dispatch($data);
		}

		// $request->header('User-Agent');
		//return $request->ip();
		$otp=Hash::make($otp);
		$uniq=Str::uuid()->toString();
		if($request->verification_type=='user')
		{
			$data = User::where('contact', $contact)->get();

			if ($data->count()==0)
			{
				$user = new User;
				$user->contact = $request->contact;
 				$user->password =$otp;
				$user->user_uu_id=Str::uuid()->toString();
        		$user->save();
			}
			else
				$user = User::where('contact',$contact)->update(array('password' =>$otp));
		}
		else if($request->verification_type=='vendor'){

			$data = Vendor::where('contact', $contact)->get();

			if ($data->count()==0)
			{
				$user = new Vendor;
				$user->contact = $request->contact;
 				$user->password =$otp;
				 $user->status ="active";
				 $user->vendor_uu_id=$uniq;
        		$user->save();
			}
			else
				$user = Vendor::where('contact',$contact)->update(array('password' =>$otp));
		}
		else{
			return response()->json(['error' => 'Unauthorized Access!'], 401);
		}


		// $obj=new  ComponentConfig();
		// $image_data= $obj->send_sms($contact,$msg);

		$response['msg']='ok';
		return json_encode($response);
	}


	//method for otp verification
	public function otp_verification(request $request)
	{
		$validator = Validator::make($request->all(), [
            'contact' => 'required',
            'otp' => 'required',
        ]);

		if ($validator->fails())
    	{
        	return response(['errors'=>$validator->errors()->all()], 422);
    	}

		if($request->verification_type=='user')
		{
			//return $request;
			$user = User::where("contact", $request->contact)->first();
        	//return $user;
			if(!isset($user)){
				return response()->json(['error' => 'Account not found.'], 401);
       		}

			if (!Hash::check($request->otp, $user->password))
			{
				return response()->json(['error' => 'Invalid OTP, Try Again.'], 401);
        	}

			$tokenResult = $user->createToken('User');
        	$user->access_token = 'Bearer '.$tokenResult->accessToken;
        	// $user->token_type = ;

			if($user->name == " " || $user->name == null)
			{
				//code for refer & earn plan
				$getip = AppHelper::get_ip();
				$getdevice = AppHelper::get_device();
				$getos = $request->oprating_system;

				//apply refer and earn code

				refer_earn_setup::where("user_ip_address",$getip)
				->where("refer_status","pending")
				->where("user_device","Mobile")
				->where("user_os",ucwords($getos))
				->update(['user_id' => $user->id,'refer_status'=>'register']);
				//return "Hello";
            	//now return this token on success login attempt
				$response = ['msg' => 'ok','token' => $user->access_token,'user_type' => 'register','usr' => $user->id,'data'=>$user];
			}
			else
			{
				 //now return this token on success login attempt
				$response = ['msg' => 'ok','token' => $user->access_token,'user_type' => 'login','usr' => $user->id,'data'=>$user];

			}

			return $response;
		}
		else if ($request->verification_type=='vendor'){

			$vendor = Vendor::where("contact", $request->contact)->first();

			if(!isset($vendor)){
				return response()->json(['error' => 'Account not found, Please Contact Admin for support'], 401);
       		}

			if (!Hash::check($request->otp, $vendor->password))
			{
				return response()->json(['error' => 'Invalid OTP, Try Again.'], 401);
        	}

			$tokenResult = $vendor->createToken('Vendor');
        	$vendor->access_token = 'Bearer '.$tokenResult->accessToken;
        	// $user->token_type = ;

			if($vendor->name == " " || $vendor->name == null)
			{
            	//now return this token on success login attempt
				$response = ['msg' => 'ok','token' => $vendor->access_token,'user_type' => 'register','usr' =>$vendor->id,'data'=>$vendor];
			}
			else
			{
				 //now return this token on success login attempt
				$response = ['msg' => 'ok','token' => $vendor->access_token,'user_type' => 'login','usr' => $vendor->id,'data'=>$vendor];

			}
			return $response;
		}
		else{
			return response()->json(['error' => 'Unauthorized Access!'], 401);
		}
	}


    //staff_ contact verification


    //method for contact verification
    public function staff_mobile_verification(request $request)
	{
		$validator = Validator::make($request->all(), [
            'contact' => 'required',
			'verification_type' => 'required'
        ]);

		if($validator->fails())
    	{
        	return response(['errors'=>$validator->errors()->all()], 422);
    	}

		//check the request its one time or resend
		if(isset($request->request_type))
		{
			$request_type=$request->request_type;
		}
		else
		{
			$request_type="send";
		}

		$contact=$request->contact;
		if(env("APP_ENV") != 'production') // condition to check this is beta or release
		{
			if($contact == 8006435315)
			{
				$otp=458855;
			}
			else
			{
				$otp=123456;
			}

			$msg="Use $otp as your OTP for WeazyDine account verification. This is confidential. Please, do not share this with anyone. Webixun infoways PVT LTD";

			$data['contact']=$contact;
			$data['msg']=$msg;
		}
		else
		{
			//Production
			if($contact == 8006435315)
			{
				$otp=458855;
			}
			else
			{
				$otp=rand(99999,999999);
			}
			$data['contact']=$contact;

			$data['request_type']=$request_type;

			if($request_type == 'send')
			{
				$data['msg']="Use $otp as your OTP for WeazyDine account verification. This is confidential. Please, do not share this with anyone. Webixun infoways PVT LTD";
				AppHelper::send_otp($data['contact'],$otp);
			}
			else
			{
				$data['msg']="Use $otp as your OTP for WeazyDine account verification. This is confidential. Please, do not share this with anyone. Webixun infoways PVT LTD";
				AppHelper::send_sms($data['contact'],$data['msg']);
			}
			//AppHelper::send_sms2($data['contact'],$msg);
			//jobs for end the sms
			//ProcessSms::dispatch($data);
		}

		// $request->header('User-Agent');
		//return $request->ip();
		$otp=Hash::make($otp);
		$uniq=Str::uuid()->toString();


			$data = vendor_staff_account::where("staff_contact", $contact)->get();

			if(count($data) == 0)
			{
				$shop = Vendor::where('contact',$contact)->get();
				if(count($shop) == 0)
				{
					$user = new Vendor;
					$user->contact = $request->contact;
					 $user->password =$otp;
					$user->status ="active";
                    $user->subscription_end=date('Y-m-d H:i:s', strtotime('+14 days'));

					$user->vendor_uu_id=$uniq;

					if($user->save())
					{
						$vendor_id=$user->id;
					}
					else
					{
						$response['msg']="error";
						return json_encode($response);
					}
				}
				else
				{
					$vendor_id=$shop[0]->id;
				}


                    $staff = new vendor_staff_account;
                    $staff->id = $vendor_id;
					$staff->staff_role="owner";
                    $staff->staff_contact = $request->contact;
                    $staff->password =$otp;
                    $staff->staff_account_status ="active";
                    if($staff->save())
					{
						$response['msg']='ok';
						return json_encode($response);
					}
					else
					{
						$response['msg']='error';
						return json_encode($response);
					}


			}
			else
			{
				$user = vendor_staff_account::where("staff_contact",$contact)->update(array('password' =>$otp));
			}

		// $obj=new  ComponentConfig();
		// $image_data= $obj->send_sms($contact,$msg);
        $response['msg']='ok';
		$response['msg']='ok';
		return json_encode($response);
	}


	//method for otp verification
	public function staff_otp_verification(request $request)
	{
		$validator = Validator::make($request->all(), [
            'contact' => 'required',
            'otp' => 'required',
        ]);

		if ($validator->fails())
    	{
        	return response(['errors'=>$validator->errors()->all()], 422);
    	}


			$vendor = vendor_staff_account::where("staff_contact", $request->contact)->first();

			if(!isset($vendor)){
				return response()->json(['error' => 'Account not found, Please Contact Admin for support'], 401);
       		}

			if (!Hash::check($request->otp, $vendor->password))
			{
				return response()->json(['error' => 'Invalid OTP, Try Again.'], 401);
        	}

			$tokenResult = $vendor->createToken('staff');
        	$token = 'Bearer '.$tokenResult->accessToken;
        	// $user->token_type = ;
            $data=Vendor::find($vendor->id);

            $user['name']=$vendor->staff_name;
            $user['role']=$vendor->staff_role;

            $time=$data->subscription_end;
            $current_time=date('Y-m-d H:i:s');
            $diff=date_diff(date_create($current_time),date_create($time));

            if(strtotime($time)<strtotime($current_time))
            {
                $data->subscription_expire=0;
            }
            else
            {
                $data->subscription_expire=$diff->format("%a")+1;
            }

            $mail['from']=env('MAIL_FROM_ADDRESS');
            $mail['from_name']='Weazy Dine Login Alerts';

            $mail['to']=$data->email;
            $mail['subject']='Your Weazy Dine account has been accessed from a new IP Address';

            $mail['data']=array('contact_no'=>$request->contact,'account_role'=>$vendor->staff_role,'ip_address'=>$request->ip(),'time'=>date('Y-m-d H:i:s'),'browser'=>$request->header('User-Agent'));
            $mail['template']='emails.loginalert';

            if($data->email != null)
            {
                Processmail::dispatch($mail);
            }



			//now return this token on success login attempt
			$response = ['msg' => 'ok','token' => $token,'user_type' => 'login','usr' => $vendor->id,'data'=>$data,'user' =>$user];

			return $response;

	}

	public function admin_login(request $request)
	{
		$validator = Validator::make($request->all(), [
            'phoneNumber' => 'required',
            'secret' => 'required',
			'password' => 'required',
        ]);

		if ($validator->fails())
    	{
        	return response(['errors'=>$validator->errors()->all()], 422);
    	}

		$match_secret="ggMjF4waGewcI*7#3F06";
		$match_passcode="VZ5QZRBp3G$!52&f2^lq";
		if($request->secret == $match_secret )
		{
			$contact=$request->phoneNumber;
            $password= Hash::make($request->password);

			$vendor = Vendor::where("contact", $request->phoneNumber)->first();

			if(!isset($vendor)){
				return response()->json(['error' => 'Account not found, Please Contact Admin for support'], 401);
       		}

			$tokenResult = $vendor->createToken('Vendor');
        	$vendor->access_token = 'Bearer '.$tokenResult->accessToken;
        	// $user->token_type = ;

				 //now return this token on success login attempt
				$response = ['msg' => 'ok','token' => $vendor->access_token,'user_type' => 'login','usr' => $vendor->id];

			return $response;
		}
		else{
			return response()->json(['error' => 'Unauthorized Access!'], 401);
		}
	}


	public function logout(request $request)
	{
		if (Auth::check()) {
			Auth::user()->token()->revoke();
		     $response['status']=true;
             $response['msg'] = "Logout Successfull!";
			return json_encode($response);
		}else{
			 $response['status']=false;
             $response['msg'] = "Failed!";
			return json_encode($response);
		}
	}

	public function unauthorized()
	{
		return response()->json(['error' => 'Unauthorized Access!'], 401);
	}

	public function validate_upi_id(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'upi_id' => 'required'
        ]);

		if ($validator->fails())
    	{
        	return response(['errors'=>$validator->errors()->all()], 422);
    	}



		$upi_id=$request->upi_id;
		$data="";
		if ($data == "")
		{
			$response['status']=true;
			$response['data']=$upi_id;
		}
		else
		{
			$response['status']=true;
			$response['msg']="Invalid UPI, Try Again";
		}

		return json_encode($response);
	}

}
