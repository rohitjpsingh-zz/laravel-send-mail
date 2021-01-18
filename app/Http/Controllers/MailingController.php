<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Models\Model_mailing;
use App\Models\Model_import;
use App\Models\Model_email;
use App\Models\Model_report;

use DB;



class MailingController extends Controller {
	
	public function __construct() {
        $this->mailing_model = new Model_mailing();
        $this->import_model = new Model_import();
        $this->email_model = new Model_email();
        $this->report_model = new Model_report ();
    }

    public function index() {
    	$get_campaign = $this->import_model->getAllimport();
		$data['broadcast_name'] = $get_campaign;
		$data['reports'] = $this->report_model->getMailReport();
		$data['reports']->total_mail = $this->report_model->getTotalMail($data['reports']->bid);
		$data['reports']->bName = $this->import_model->getBroadcastName($data['reports']->bid)[0]->broadcast_name;

		$send_mail_contents = DB::table('tbl_mailing_contents')->select('tbl_mailing_contents.*','importcsv.broadcast_name')->join('importcsv','importcsv.id','=','tbl_mailing_contents.mailing_list')->get();

		if($send_mail_contents && count($send_mail_contents ) > 0){
			foreach ($send_mail_contents as $key => $mc) {
				$sent_id = $mc->id;
				$sent_mail_list = DB::table('tbl_sent_mail_list')->where('mailing_content_id',$sent_id)->get();
				$send_mail_contents[$key]->sent_mail_list = $sent_mail_list;
			}
		}

		// dd($send_mail_contents);

		$data['send_mail_contents'] = $send_mail_contents;
		
        return view('mailing')->with($data);
    }
	
	public function store(Request $request){
        // dd($request->all());
		$validatedData = Validator::make($request->all(), [
            'email' => 'required',
            'subject' => 'required',
            'sender_email' => 'required',
            'sender_fullname' => 'required',
            'charset' => 'required',
            'line_feed_after' => 'required',
            'format' => 'required',
            'measure_open_rate' => 'required',
			'editor_text' => 'required',
			'mailing_list' => 'required',
			'delivery_date'=>isset($request->has_email_cron) ? 'required' : '',
			'delivery_time_hour'=>isset($request->has_email_cron) ? 'required' : '',
			'delivery_time_minute'=> isset($request->has_email_cron) ? 'required' : '',
        ],
        # ---------------- Custom error messages     
            ['email.required' => "Email is required!",
            'subject.required' => 'Subject is required!',
            'sender_email.required' => 'Sender Email is required',
            'sender_fullname.required' => 'Sender Fullname is required!',
            'charset.required' => 'Charset is required!',
            'line_feed_after.required' => 'Line feed after is required!',
            'format.required' => 'Format is required!',
			'measure_open_rate.required' => 'Measure open rate is required!',
			'measure_open_rate.required' => 'Measure open rate is required!',
			'mailing_list.required' => 'Select any broadcast!',
			'delivery_date.required' => 'Delivery date is required!',
			'delivery_time_hour.required' => 'Delivery time hour is required!',
			'editor_text.required' => 'Editor text is required!',
			]);
		
		
		if ($validatedData->fails()) {
            return redirect()->back()->withInput()->withErrors($validatedData);
        } else {

			$email = $request->email;
			$description = $request->description;
			$subject = $request->subject;
			$sender_email = $request->sender_email;
			$sender_fullname = $request->sender_fullname;
			$reply_to_email = $request->reply_to_email;
			$reply_to_fullname = $request->reply_to_fullname;
			$charset = $request->charset;
			$line_feed_after = $request->line_feed_after;
			$format = $request->format;
			$measure_open_rate = $request->measure_open_rate;
			$editor_text = $request->editor_text;
			$template = $request->template;
			$archive = $request->archive;
			$show_archive = isset($request->show_archive) ? 1 : 0;
			$mailing_type = $request->mailing_type;
			$mailing_list = $request->mailing_list;
			$get_multi_email = $request->get_email_cmpgn;
			//$implode_email =  "'" . implode( "','",$get_multi_email) . "'";
			if(!isset($get_multi_email) && $get_multi_email == ""){
				$get_multi_email = $this->email_model->getAllemail($mailing_list);
			}

			$has_email_cron = isset($request->has_email_cron) ? 1 : 0;
			$delivery_date = (isset($request->has_email_cron) && isset($request->delivery_date)) ? $request->delivery_date : '';
			$delivery_time_hour = (isset($request->has_email_cron) && isset($request->delivery_time_hour)) ? $request->delivery_time_hour : '';
			$delivery_time_minute = (isset($request->has_email_cron) && isset($request->delivery_time_minute)) ? $request->delivery_time_minute : '';
		

			$dom = new \DomDocument();
			libxml_use_internal_errors(true);
			$dom->loadHtml($editor_text, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
			$images = $dom->getElementsByTagName('img');

			$rand = rand(00000000,99999999);
			foreach($images as $k => $img){
				$dataimg = $img->getAttribute('src');
				$datafilename = $img->getAttribute('data-filename');
				$explode_filename = explode(".",$datafilename);
				$extension = $explode_filename[1];

				list($type, $dataimg) = explode(';', $dataimg);
				list(, $dataimg)      = explode(',', $dataimg);
				$dataimg = base64_decode($dataimg);
				
				// Create a new filename for the image
				$newImageName = str_replace(".", "", uniqid("forum_img_", true));
				$filename = $newImageName . '.' . $extension;
				/*$image_variable = $rand.$k.".".$extension;
				$image_name= "https://u224810916//domains/onestop.company/public_html/demo/market/market/market/public/uploads/mrkt" . $image_variable;
				$path = $image_name;*/
				$image_name = 'http://hddigicorp.com/hddigi/public/uploads/' . $filename;

				// Save the image to disk
				$imgUrl = public_path() .'/uploads/'. $filename;
				$success = file_put_contents($imgUrl, $dataimg);


				/*file_put_contents($image_variable, $dataimg);*/
				
				// Update the forum thread text with an img tag for the new image
				$newImgTag = '<img src="' . $image_name . '" />';

				$img->setAttribute('src', $image_name);
				$img->setAttribute('data-original-filename', $img->getAttribute('data-filename'));
				$img->removeAttribute('data-filename');
				//$submitted_text = $doc->saveHTML();

				/*$img->removeAttribute('src');
				$img->setAttribute('src', $image_name);*/
			}

			$editor_text = $dom->saveHTML();
			
			if($reply_to_email==''){
				$reply_to_email = env('MAIL_FROM_ADDRESS');
			}

			// Save Mail Content
			$mail_content = array(
				"email"	 => $email,
				"description"	 => $description,
				"subject"	 => $subject,
				"sender_email"	 => $sender_email,
				"sender_fullname"	 => $sender_fullname,
				"reply_to_email"	 => $reply_to_email,
				"reply_to_fullname"	 => $reply_to_fullname,
				"charset"	 => $charset,
				"line_feed_after"	 => $line_feed_after,
				"format"	 => $format,
				"measure_open_rate"	 => $measure_open_rate,
				"template"	 => $template,
				"mailing_list"	 => $mailing_list,
				"archive"	 => $archive,
				"show_archive"	 => $show_archive,
				"mailing_type"	 => $mailing_type,
				"editor_text"	 => $editor_text,
				"has_email_cron"	 => $has_email_cron,
				"delivery_date"	 => $delivery_date,
				"delivery_time_hour"	 => $delivery_time_hour,
				"delivery_time_minute"	 => $delivery_time_minute,
			);
			
			$mail_content_id = DB::table('tbl_mailing_contents')->insertGetId($mail_content);
			$mailsuccessmsg = "Mail added sucessfully";

			// Save Mail to mail List
			if($mail_content_id > 0 && $get_multi_email && count($get_multi_email) > 0){
				foreach ($get_multi_email as $mkey => $mail) {
					$mail_data = array(
						"mailing_content_id" => $mail_content_id,
						"email_address"	=> $mail,
						"status" => 1
					);
					DB::table('tbl_sent_mail_list')->insertGetId($mail_data);
				}
			}


			////// Send Mail
			$details = [
				'from' => $sender_email,
				'header' => "Content-type:" . $format . ";charset=" . $charset . "\r\n",
				'subject' => $subject,
				'Reply-To' => $reply_to_email,
				'body' => $editor_text,
			];
			//$to = 'riteshhir@gmail.com';
			$from = $sender_email;

			// To send HTML mail, the Content-type header must be set
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type:' . $format . '; charset=' . $charset . '' . "\r\n";

			// Create email headers
			$headers .= 'From: ' . $from . "\r\n" .
			'Reply-To: ' . $from . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

			// Compose a simple HTML email message
			$message = ['body' => $editor_text];
			if($has_email_cron == 0 && $get_multi_email && count($get_multi_email) > 0){
				foreach ($get_multi_email as $mkey => $mail) {

					\Mail::to($mail)->send(new \App\Mail\SendMail($details));
					// $mail_data = array(
					// 	"mailing_content_id" => $mail_content_id,
					// 	"email_address"	=> $mail,
					// 	"status" => 0
					// );
					// DB::table('tbl_sent_mail_list')->insertGetId($mail_data);
				}
			}

			//////
			$records = [];
			//get all sendmail data
			$get_sendmail_list = $this->mailing_model->getAllsendmail($mail_content_id);
			$get_mails_list = $this->email_model->getAllemail($mailing_list);

			foreach ($get_sendmail_list as $key => $value) {
				# code...
				$created_at = $value['created_at'];
				$explode_date = explode(" ", $created_at);
				$date = date('Y-m-d H:i:s', strtotime($explode_date[0]));
				$start_time = $explode_date[1];
				$total_mail = count($get_mails_list);

				if ($get_sendmail_list->count() == $key) {
					$end_time = '';
				}
			}
			$records = [
				'bid' => $mailing_list,
				'start_time' => $created_at,
				'end_time' => $created_at,
				'date' => $created_at,
				'total_mail' => $total_mail
			];
			
			//save report into database
			$reportdetails = $this->report_model->insert_report($records);
			$records['total_mail'] = $this->report_model->getTotalMail($mailing_list);
			$records['bName'] = $this->import_model->getBroadcastName($mailing_list)[0]->broadcast_name;

			$get_campaign = $this->import_model->getAllimport();
			$data['broadcast_name'] = $get_campaign;
			$data['reports'] = $records;
        	
		}
		
		return Redirect::to('/mailing')->with(['mailsuccessmsg' => $mailsuccessmsg])->with($data);
	}

	public function getemailbyname(Request $request){
		
		 $get_mails_list1 = $this->email_model->getAllemail($request['bid']);
		
        foreach ($get_mails_list1 as $allmailkey => $allmaildata) {
            if (isset($allmaildata)) {
                $retdata[$allmailkey]['id'] = $allmaildata['eid'];
                $retdata[$allmailkey]['email'] = $allmaildata['email'];
            } else {
                $retdata[] = "No data available!";
            }
        }
        echo json_encode($retdata);
	}

	public function uploadimage(){
		// A list of permitted file extensions
    $allowed = array('png', 'jpg', 'gif','zip');
     if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){

     	$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
     	if(!in_array(strtolower($extension), $allowed)){
	     	echo '{"status":"error"}';
	     	exit;
	    }
     	if(move_uploaded_file($_FILES['file']['tmp_name'],'images/'.$_FILES['file']['name'])){
	     	$tmp='uploads/'.$_FILES['file']['name'];
	     	$new = '../uploads/'.$_FILES['file']['name']; //adapt path to your needs;
     		if(copy($tmp,$new)){
     			echo 'uploads/'.$_FILES['file']['name'];
	    		//echo '{"status":"success"}';
			}
	     	exit;
	    }
    }
 	echo '{"status":"error"}';
 	exit;
	}
}
