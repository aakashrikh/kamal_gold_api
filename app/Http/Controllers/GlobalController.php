<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Storage;
use App\Models\Vendor_category;
use App\Models\Vendor;
use App\Models\Vendor_Product;
use App\Models\vendor_table;
use App\Models\vendor_products_variant;
use Illuminate\Support\Facades\Validator;
use Mpdf\Mpdf;
use App\Models\UserOrders;
use App\Models\user_order_product;
use Mpdf\Output\Destination;
class GlobalController extends Controller
{

	public function update_data_csv(Request $request)
	{
		if($request->auth_key != 'OiiDu^hrmVf27kdJNZ66Vd74S$KY&Mx8$JV')
		{
			return "invalid Key";
		}
		$contact=$request->contact;

		$vendor=Vendor::where('contact',$contact)->get();

		if(count($vendor)==0)
		{
			return "invalid contact";
		}
		$vendor_id=$vendor[0]->id;

		$file = $request->file('csv');
   		$file_name=time().uniqid(rand()).$file->getClientOriginalName();

		//Move Uploaded File
      	$destinationPath = 'uploads/';
      	$file->move($destinationPath,$file_name);

		$files = $destinationPath.$file_name;

    	$customerArr = $this->csvToArray($files);

	//	return print_r($customerArr);

		for ($i = 0; $i < count($customerArr); $i ++)
    	{
//			return (count($customerArr[$i]));
			$matchThese = ['vendor_id'=>$vendor_id,'name'=>$customerArr[$i]['category']];
			$cat=Vendor_category::updateOrCreate($matchThese,['status'=>'active']);
			$category_id=$cat->id;

			$product = Vendor_Product::where('product_name',$customerArr[$i]['name'])->where('vendor_id',$vendor_id)->get();

			if(count($product)==0)
			{
			//insert the product
			$product = Vendor_Product::create(['vendor_id'=>$vendor_id,
												'vendor_category_id'=>$category_id,
												'product_name'=>$customerArr[$i]['name'],
											  	'product_img'=>$customerArr[$i]['image'],
											   	'market_price'=>$customerArr[$i]['market_price'],
											   	'our_price'=>$customerArr[$i]['our_price'],
											  	'is_veg'=>$customerArr[$i]['is_veg'],
											  	'description'=>$customerArr[$i]['description'],
											  	'status'=>'active',
											  	'type'=>$customerArr[$i]['type'],
											  ]);

			//insert the varient if have

			$varient=count($customerArr[$i]);

		//	return $varient;
			$count=1;
			$k=9;
			while($k < $varient)
			{
				if(isset($customerArr[$i]['varient'.$count]) && $customerArr[$i]['varient'.$count] != '' && isset($customerArr[$i]['v_price'.$count]) && $customerArr[$i]['v_price'.$count] != '' && isset($customerArr[$i]['v_offer_price'.$count]) && $customerArr[$i]['v_offer_price'.$count] != '')
				{
					vendor_products_variant::create([
						'product_id'=>$product->id,
    				'variants_name' => $customerArr[$i]['varient'.$count],
    				'variants_price' => $customerArr[$i]['v_price'.$count],
    				'variants_discounted_price' => $customerArr[$i]['v_offer_price'.$count],
					]);

				}


				$k=$k+3;
				$count++;
			}
			}

  		}


		unlink($files);
		return "Uploading Successfull";

	}


	function csvToArray($filename = '', $delimiter = ',')
{
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
        {
            if (!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }

    return $data;
}


	public function show_qr_image(Request $request)
	{
		$table=vendor_table::with('vendor')->where('table_uu_id',$request->table_uu_id)->get();

		if(count($table)==0)
		{
			return "Invalid URL";
		}


		$link=env('APP_URL').'/'.$table[0]->table_uu_id.'/dineinlisting';
		$qr_code="https://chart.googleapis.com/chart?chs=540x540&cht=qr&chl=$link&choe=UTF-8";
		 // Load the stamp and the photo to apply the watermark to
		$stamp = imagecreatefrompng($qr_code);
		$im = imagecreatefrompng('QR.png');

		// Set the margins for the stamp and get the height/width of the stamp image
		$marge_right = 330;
		$marge_bottom = 450;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);


		// Set Text to Be Printed On Image
		$im2 = imagecreatetruecolor(800, 250);

				  // Get image dimensions
		  $width = imagesx($im);
		  $height = imagesy($im);
		// Get center coordinates of image
		  $centerX = $width / 2;
		  $centerY = $height / 2;
		// Get size of text
		  list($left, $bottom, $right, , , $top) = imageftbbox(55, 0, realpath('Roboto.ttf'),$table[0]->vendor->name);
		// Determine offset of text
		  $left_offset = ($right - $left) / 2;
		  $top_offset = ($bottom - $top) / 2;
		// Generate coordinates
		  $x = $centerX - $left_offset;
		  $y = $centerY + $top_offset;
		// Add text to image


		// Add text using a font from local file
		$dataArr = imagettftext($im,55, 0,$x, 500,
        imagecolorallocate($im2, 0, 0, 0),
        realpath('Roboto.ttf'), $table[0]->vendor->name);



		// Get size of text
  list($left, $bottom, $right, , , $top) = imageftbbox(50, 0, realpath('Roboto.ttf'),'Menu - '.$table[0]->table_name);
// Determine offset of text
  $left_offset = ($right - $left) / 2;
  $top_offset = ($bottom - $top) / 2;
// Generate coordinates
  $x = $centerX - $left_offset;
  $y = $centerY + $top_offset;
// Add text to image


			// Set Text to Be Printed On Image
		$im2 = imagecreatetruecolor(800, 250);

		// Add text using a font from local file
		$dataArr = imagettftext($im,50, 0, $x, 1530,
        imagecolorallocate($im2, 0, 0, 0),
        realpath('Roboto.ttf'), 'Menu - '.$table[0]->table_name);


		// Copy the stamp image onto our photo using the margin offsets and the photo
		// width to calculate positioning of the stamp.
		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

		// Output and free memory
		header('Content-type: image/png');


		if(isset($request->type))
		{

			if($request->type == 'img')
			{
				imagepng($im);
			}
			else
			{

				$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [101.6, 152.4],'margin_left' => 0.5,'margin_right' => 0,'margin_top' => 0.7,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]);
//
        		$name='QR-Images/'.time().'.png';
				imagepng($im,$name);

				$html='<img src="'.$name.'"/>';
        		//write content

				$mpdf->WriteHTML($html);


				//return the PDF for download
				$mpdf->Output(time().'.pdf', "D");

				unlink($name);
				return "Please Wait your file is downloading";
			}
		}
		else
		{
			imagepng($im);
		}
        imagedestroy($im);
	}



    public function show_qr_shop(Request $request)
	{
		$table=Vendor::find($request->vendor_id);

		if($table==null)
		{
			return "Invalid URL";
		}


		$link=env('APP_URL').'/'.$table->id.'/takeawaylisting';
		$qr_code="https://chart.googleapis.com/chart?chs=540x540&cht=qr&chl=$link&choe=UTF-8";
		 // Load the stamp and the photo to apply the watermark to
		$stamp = imagecreatefrompng($qr_code);
		$im = imagecreatefrompng('QR.png');

		// Set the margins for the stamp and get the height/width of the stamp image
		$marge_right = 330;
		$marge_bottom = 450;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);


		// Set Text to Be Printed On Image
		$im2 = imagecreatetruecolor(800, 250);

				  // Get image dimensions
		  $width = imagesx($im);
		  $height = imagesy($im);
		// Get center coordinates of image
		  $centerX = $width / 2;
		  $centerY = $height / 2;
		// Get size of text
		  list($left, $bottom, $right, , , $top) = imageftbbox(55, 0, realpath('Roboto.ttf'),$table->shop_name);
		// Determine offset of text
		  $left_offset = ($right - $left) / 2;
		  $top_offset = ($bottom - $top) / 2;
		// Generate coordinates
		  $x = $centerX - $left_offset;
		  $y = $centerY + $top_offset;
		// Add text to image


		// Add text using a font from local file
		$dataArr = imagettftext($im,55, 0,$x, 500,
        imagecolorallocate($im2, 0, 0, 0),
        realpath('Roboto.ttf'), $table->shop_name);



		// Get size of text
  list($left, $bottom, $right, , , $top) = imageftbbox(50, 0, realpath('Roboto.ttf'),'Menu ');
// Determine offset of text
  $left_offset = ($right - $left) / 2;
  $top_offset = ($bottom - $top) / 2;
// Generate coordinates
  $x = $centerX - $left_offset;
  $y = $centerY + $top_offset;
// Add text to image


			// Set Text to Be Printed On Image
		$im2 = imagecreatetruecolor(800, 250);

		// Add text using a font from local file
		$dataArr = imagettftext($im,50, 0, $x, 1530,
        imagecolorallocate($im2, 0, 0, 0),
        realpath('Roboto.ttf'), 'Menu ');


		// Copy the stamp image onto our photo using the margin offsets and the photo
		// width to calculate positioning of the stamp.
		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

		// Output and free memory
		header('Content-type: image/png');


		if(isset($request->type))
		{

			if($request->type == 'img')
			{
				imagepng($im);
			}
			else
			{

				$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [101.6, 152.4],'margin_left' => 0.5,'margin_right' => 0,'margin_top' => 0.7,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]);
//
        		$name='QR-Images/'.time().'.png';
				imagepng($im,$name);

				$html='<img src="'.$name.'"/>';
        		//write content

				$mpdf->WriteHTML($html);


				//return the PDF for download
				$mpdf->Output(time().'.pdf', "D");

				unlink($name);
				return "Please Wait your file is downloading";
			}
		}
		else
		{
			imagepng($im);
		}
      //  imagedestroy($im);
	}

	function show_bill_pdf(Request $request)
	{
		$data=UserOrders::with('user')->with('vendor')->with('transactions')->with('table')->where('order_code',$request->order_code)->orderByDesc('id')->get();
        // return $data[0]->transactions;
		if(count($data)>0)
        {
			$order_id=$data[0]->id;
			$data[0]['cart']=user_order_product::with(['product','variant','addons'])->where('order_id',$order_id)->get();


		//return view('printBill')->with('data',$data);
			$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [80, 152.4],'margin_left' => 0,'margin_right' => 0,'margin_top' => 0.2,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]);
//
        		//write content

			//	$stylesheet = file_get_contents('billStyle.css');
				// $mpdf->WriteHTML($stylesheet,1);
				$mpdf->WriteHTML(view('printBill')->with('data',$data));

				//return the PDF for download
				$mpdf->Output(time().'.pdf', "I");
				return "Please Wait your file is downloading";

        }
        else
        {
            return "Invalid url, Try again.";
        }

	}

	function show_kot_pdf(Request $request)
	{
		$data=UserOrders::with('user')->with('vendor')->with('transactions')->with('table')->where('order_code',$request->order_code)->orderByDesc('id')->get();
        // return $data[0]->transactions;
		if(count($data)>0)
        {
			$order_id=$data[0]->id;
			$data[0]['cart']=user_order_product::with(['product','variant','addons'])->where('order_id',$order_id)->get();


		//return view('printBill')->with('data',$data);
			$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [80, 152.4],'margin_left' => 0,'margin_right' => 0,'margin_top' => 0.2,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]);
//
        		//write content

			//	$stylesheet = file_get_contents('billStyle.css');
				// $mpdf->WriteHTML($stylesheet,1);
				$mpdf->WriteHTML(view('printKot')->with('data',$data));

				//return the PDF for download
				$mpdf->Output(time().'.pdf', "I");
				return "Please Wait your file is downloading";

        }
        else
        {
            return "Invalid url, Try again.";
        }

	}



	public function genrate_qr($link,$vendor_name,$table_name)
	{
		//echo "fone";

		$qr_code="https://chart.googleapis.com/chart?chs=540x540&cht=qr&chl=$link&choe=UTF-8";
		 // Load the stamp and the photo to apply the watermark to
		$stamp = imagecreatefrompng($qr_code);
		$im = imagecreatefrompng('QR.png');

		// Set the margins for the stamp and get the height/width of the stamp image
		$marge_right = 330;
		$marge_bottom = 450;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		// Copy the stamp image onto our photo using the margin offsets and the photo
		// width to calculate positioning of the stamp.
		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

		// Set Text to Be Printed On Image
		$im2 = imagecreatetruecolor(800, 250);

		  // Get image dimensions
		  $width = imagesx($im);
		  $height = imagesy($im);
		// Get center coordinates of image
		  $centerX = $width / 2;
		  $centerY = $height / 2;
		// Get size of text
		  list($left, $bottom, $right, , , $top) = imageftbbox(60, 0, realpath('Roboto.ttf'),$vendor_name);
		// Determine offset of text
		  $left_offset = ($right - $left) / 2;
		  $top_offset = ($bottom - $top) / 2;
		// Generate coordinates
		  $x = $centerX - $left_offset;
		  $y = $centerY + $top_offset;
		// Add text to image


			// Add text using a font from local file
			$dataArr = imagettftext($im,60, 0,$x, 500,
			imagecolorallocate($im2, 0, 0, 0),
			realpath('Roboto.ttf'),$vendor_name);



					// Get size of text
			  list($left, $bottom, $right, , , $top) = imageftbbox(50, 0, realpath('Roboto.ttf'),"Menu - ".$table_name);
			// Determine offset of text
			  $left_offset = ($right - $left) / 2;
			  $top_offset = ($bottom - $top) / 2;
			// Generate coordinates
			  $x = $centerX - $left_offset;
			  $y = $centerY + $top_offset;
			// Add text to image


				// Set Text to Be Printed On Image
			$im2 = imagecreatetruecolor(800, 250);

			// Add text using a font from local file
			$dataArr = imagettftext($im,50, 0, $x, 1530,
			imagecolorallocate($im2, 0, 0, 0),
			realpath('Roboto.ttf'), "Menu - ".$table_name);




		// Output and free memory
		header('Content-type: image/png');

		$name='QR-Images/'.time().'_'.Auth::user()->id.'.png';
		if(imagepng($im,$name))
		{
			$response['status']=true;
			$response['link']=env('APP_API_URL')."/".$name;
		}
		else
		{
			$response['status']=false;
		}

		return $response;
	}


  public function removeprevious()
  {
    $current_pic=Auth::user()->profile_pic;
    //code for delete the file from storage
    $nf= str_replace(env('APP_CDN_URL'),'',$current_pic);
    Storage::disk(env('DEFAULT_STORAGE'))->delete($nf);
  }

  public function upload_img($file,$path)
  {
    $file_name = time().'.'.$file->getClientOriginalExtension();
    $res = Storage::disk(env('DEFAULT_STORAGE'))->put($path.$file_name,file_get_contents($file));
    if($res){
      $response['status']=true;
      $response['file_name']=env('APP_CDN_URL').$path.$file_name;
    }else{
      $response['status']=false;
    }
    return $response;
  }


    public function upload_files($files,$feed_id,$path)
    {
      $data=array();
      foreach($files as $file){
          //create unique name of file uploaded.
          $name=time().'_'.$file->getClientOriginalName();
          $res = Storage::disk('shared')->put($path.'/'.$name,file_get_contents($file));
          if($res)
          {
              $data[] = ['feed_id'=>$feed_id, 'content_src'=> $path."/".$name,'content_type' => 'image'];
          }
      }
      $res = feed_content::insert($data);
      if($res){
        return true;
      }
      else{
        return false;
      }
    }
}
