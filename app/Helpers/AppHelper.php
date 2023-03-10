<?php

namespace App\Helpers;
class AppHelper
{
	public static function send_otp($contact,$msg)
	{
		$curl = curl_init();
		curl_setopt_array($curl, [
  		CURLOPT_URL => "https://api.msg91.com/api/v5/otp?template_id=635a3f8cd6fc051e5d2fd9a3&otp_expiry=10&mobile=91$contact&authkey=384161AlfcBJhZ635a3920P1&otp=$msg&invisible=123123",
  		CURLOPT_RETURNTRANSFER => true,
  		CURLOPT_ENCODING => "",
  		CURLOPT_MAXREDIRS => 10,
  		CURLOPT_TIMEOUT => 30,
  		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  		CURLOPT_CUSTOMREQUEST => "GET",
  		CURLOPT_POSTFIELDS => "{\"brandname\":\"aakash\",\"Value2\":\"Param2\",\"Value3\":\"Param3\"}",
  		CURLOPT_HTTPHEADER => [
    		"Content-Type: application/json"
  			],
			]);

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			return "cURL Error #:" . $err;
			} else {
			return $response;
			}
	}
      public static function send_sms2($contact,$msg)
      {
         	$apiKey = urlencode('MjJkMjcwNGMwMTQ5NzllM2VhZGQwNmI0MjBiNjMyYjQ=');
			$sender = urlencode('HRABIT');

			// Prepare data for POST request
			$data = array('apikey' => $apiKey, 'numbers' => $contact, 'sender' => $sender, 'message' => urlencode($msg));

			$url="http://api.textlocal.in/send/?sender=".$sender."&message=".urlencode($msg)."&apikey=".$apiKey."&numbers=".$contact;

			try
			{
				$ret = file_get_contents($url);
			}
			catch(Exception $e)
			{
				return $e->getMessage();
			}
	  }

	  public static function send_sms($contact,$msg)
      {
		  	$username = urlencode("r499");
			$msg_token = urlencode("PAzUD0");
			$sender_id = urlencode("WEBIXN"); // optional (compulsory in transactional sms)
			$message = urlencode($msg);
			$mobile = urlencode($contact);
			$url = "https://manage.hivemsg.com/api/send_transactional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile;

			try
			{
				$ret = file_get_contents($url);
			}
			catch(Exception $e)
			{
				return $e->getMessage();
			}
	  }

	  public static function send_sms3($contact,$msg)
	  {
			$sms_username ='webixunotp';
			$sendername = 'WEBIXN';
			$smstype   = 'TRANS';
			$apikey   = '2b11088f-109f-4b04-b639-833bc4160fdd';
			$url="http://88.99.147.101/sendSMS?username=$sms_username&message=".urlencode($msg)."&sendername=$sendername&smstype=$smstype&numbers=$contact&apikey=$apikey";

			try
			{
				$ret = file_get_contents($url);
			}
			catch(Exception $e)
			{
				return $e->getMessage();
			}

			return $ret;
	  }

	  public static function send_Push($heading,$url,$user_type,$subscriber,$desc)
      {

		//return env('ONE_SIGNAL_APPID');
		$content      = array(
        "en" => 'Tap here to view'
		);

		$heading = array(
		"en" => $heading
		);

		$us=$subscriber;

		if($user_type == 'user')
		{
			$tag="WEAZY-Users";
			$arr=array(array("field"=>"tag","key"=>"id","relation" => "=","value"=>$us),array("operator" => "AND"),array("field" => "tag","key"=>"account_type", "relation" => "=", "value" => "user-@aakasgfsusfd77232927ns"));

		}
		else
		{
			$tag="WEAZY-Vendor";
			$arr=array(array("field"=>"tag","key"=>"id","relation" => "=","value"=>$us),array("operator" => "AND"),array("field" => "tag","key"=>"account_type", "relation" => "=", "value" => "vendor-bmguj1sfd77232927ns"));

		}

		$fields = array(
        'app_id' => env('ONE_SIGNAL_APPID')
        ,

        'data' => array(
            "foo" => "bar"
        ),
		'filters' => $arr,
        'contents' => $content,
		'headings' => $heading,
		'url'=>$url
		);

		$fields = json_encode($fields);
		// print("\nJSON sent:\n");

		// print($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',
			'Authorization: Basic '.env('ONE_SIGNAL_RESTKEY'),
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;

      }


	  private static function get_user_agent(){
  		return $_SERVER['HTTP_USER_AGENT'];
  	}

  	public static function get_ip(){

      $ipaddress = '';
         if (isset($_SERVER['HTTP_CLIENT_IP']))
             $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
         else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
             $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
         else if(isset($_SERVER['HTTP_X_FORWARDED']))
             $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
         else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
             $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
         else if(isset($_SERVER['HTTP_FORWARDED']))
             $ipaddress = $_SERVER['HTTP_FORWARDED'];
         else if(isset($_SERVER['REMOTE_ADDR']))
             $ipaddress = $_SERVER['REMOTE_ADDR'];
         else
             $ipaddress = 'UNKNOWN';
         return $ipaddress;

  	}

  	public static function get_os(){

  		$user_agent = self::get_user_agent();
  		$os_platform = "Unknown OS Platform";
  		$os_array = array(
  			'/windows nt 10/i'  => 'Windows 10',
  			'/windows nt 6.3/i'  => 'Windows 8.1',
  			'/windows nt 6.2/i'  => 'Windows 8',
  			'/windows nt 6.1/i'  => 'Windows 7',
  			'/windows nt 6.0/i'  => 'Windows Vista',
  			'/windows nt 5.2/i'  => 'Windows Server 2003/XP x64',
  			'/windows nt 5.1/i'  => 'Windows XP',
  			'/windows xp/i'  => 'Windows XP',
  			'/windows nt 5.0/i'  => 'Windows 2000',
  			'/windows me/i'  => 'Windows ME',
  			'/win98/i'  => 'Windows 98',
  			'/win95/i'  => 'Windows 95',
  			'/win16/i'  => 'Windows 3.11',
  			'/macintosh|mac os x/i' => 'Mac OS X',
  			'/mac_powerpc/i'  => 'Mac OS 9',
  			'/linux/i'  => 'Linux',
  			'/ubuntu/i'  => 'Ubuntu',
  			'/iphone/i'  => 'ios',
  			'/ipod/i'  => 'iPod',
  			'/ipad/i'  => 'ios',
  			'/android/i'  => 'Android',
  			'/blackberry/i'  => 'BlackBerry',
  			'/webos/i'  => 'Mobile',
  		);

  		foreach ($os_array as $regex => $value){
  			if(preg_match($regex, $user_agent)){
  				$os_platform = $value;
  			}
  		}
  		return $os_platform;
  	}

  	public static function get_browsers(){

  		$user_agent= self::get_user_agent();

  		$browser = "Unknown Browser";

  		$browser_array = array(
  			'/msie/i'  => 'Internet Explorer',
  			'/Trident/i'  => 'Internet Explorer',
  			'/firefox/i'  => 'Firefox',
  			'/safari/i'  => 'Safari',
  			'/chrome/i'  => 'Chrome',
  			'/edge/i'  => 'Edge',
  			'/opera/i'  => 'Opera',
  			'/netscape/'  => 'Netscape',
  			'/maxthon/i'  => 'Maxthon',
  			'/knoqueror/i'  => 'Konqueror',
  			'/ubrowser/i'  => 'UC Browser',
  			'/mobile/i'  => 'Safari Browser',
  		);

  		foreach($browser_array as $regex => $value){
  			if(preg_match($regex, $user_agent)){
  				$browser = $value;
  			}
  		}
  		return $browser;
  	}

  	public static function get_device(){

  		$tablet_browser = 0;
  		$mobile_browser = 0;

  		if(preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))){
  			$tablet_browser++;
  		}

  		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))){
  			$mobile_browser++;
  		}

  		if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),
  		'application/vnd.wap.xhtml+xml')> 0) or
  			((isset($_SERVER['HTTP_X_WAP_PROFILE']) or
  				isset($_SERVER['HTTP_PROFILE'])))){
  					$mobile_browser++;
  		}

  			$mobile_ua = strtolower(substr(self::get_user_agent(), 0, 4));
  			$mobile_agents = array(
  				'w3c','acs-','alav','alca','amoi','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
  				'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',

  				'newt','noki','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',

  				'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
  				'wapr','webc','winw','winw','xda','xda-');

  				if(in_array($mobile_ua,$mobile_agents)){
  					$mobile_browser++;
  				}

  				if(strpos(strtolower(self::get_user_agent()),'opera mini') > 0){
  					$mobile_browser++;

  					//Check for tables on opera mini alternative headers

  					$stock_ua =
  					strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?
  					$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:
  					(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?
  					$_SERVER['HTTP_DEVICE_STOCK_UA']:''));

  					if(preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)){
  						$tablet_browser++;
  					}
  				}

  				if($tablet_browser > 0){
  					//do something for tablet devices

  					return 'Tablet';
  				}
  				else if($mobile_browser > 0){
  					//do something for mobile devices

  					return 'Mobile';
  				}
  				else{
  					//do something for everything else
  						return 'Computer';
  				}

  	}


	public static function get_date_range($type)
	{
		if($type=="today")
		{
			$from = date("Y-m-d 00:00:00");
			$to = date("Y-m-d 23:59:59");
		}
		else if($type=="yesterday")
		{
			$from = date("Y-m-d 00:00:00",strtotime("-1 days"));
			$to = date("Y-m-d 23:59:59",strtotime("-1 days"));
		}
		else if($type=="thisweek")
		{
			$from = date("Y-m-d 00:00:00",strtotime("monday this week"));
			$to = date("Y-m-d 23:59:59",strtotime("sunday this week"));
		}
		else if($type=="lastweek")
		{
			$from = date("Y-m-d 00:00:00",strtotime("monday last week"));
			$to = date("Y-m-d 23:59:59",strtotime("sunday last week"));
		}
		else if($type=="thismonth")
		{
			$from = date("Y-m-d 00:00:00",strtotime("first day of this month"));
			$to = date("Y-m-d 23:59:59",strtotime("last day of this month"));
		}
		else if($type=="lastmonth")
		{
			$from = date("Y-m-d 00:00:00",strtotime("first day of last month"));
			$to = date("Y-m-d 23:59:59",strtotime("last day of last month"));
		}
		else if($type=="thisyear")
		{
			$from = date("Y-m-d 00:00:00",strtotime("first day of january this year"));
			$to = date("Y-m-d 23:59:59",strtotime("last day of december this year"));
		}
		else if($type=="lastyear")
		{
			$from = date("Y-m-d 00:00:00",strtotime("first day of january last year"));
			$to = date("Y-m-d 23:59:59",strtotime("last day of december last year"));
		}
		else if($type=="lifetime")
		{
			$from = date("Y-m-d 00:00:00",strtotime("first day of january 2010"));
			$to = date("Y-m-d 23:59:59");
		}
		else
		{
			$from = date("Y-m-d 00:00:00");
			$to = date("Y-m-d 23:59:59");
		}

		$response['from']=$from;
		$response['to']=$to;
		return $response;
	}
}
?>
