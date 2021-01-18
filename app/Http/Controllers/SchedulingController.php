<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 
 */
class SchedulingController extends Controller
{
	$validatedData = Validator::make($request->all(), [
        'email' => 'required',
        'subject' => 'required',
        'sender_email' => 'required',
        'sender_fullname' => 'required',
        'charset' => 'required',
        'line_feed_after' => 'required',
        'format' => 'required',
        'measure_open_rate' => 'required',
        'editor_text' => 'required'
    ],
    # ---------------- Custom error messages     
        ['email.required' => "Email is required!",
        'subject.required' => 'Subject is required!',
        'sender_email.required' => 'Sender Email is required',
        'sender_fullname.required' => 'Sender Fullname is required!',
        'charset.required' => 'Charset is required!',
        'line_feed_after.required' => 'Line feed after is required!',
        'format.required' => 'Format is required!',
        'measure_open_rate.required' => 'Measure open rate is required!']);
	
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
	$mailing_list = $request->mailing_list;
	$get_multi_email = $request->get_email_cmpgn;
	//$implode_email =  "'" . implode( "','",$get_multi_email) . "'";
	if(!isset($get_multi_email) && $get_multi_email == ""){
	    $get_multi_email = $this->email_model->getAllemail($mailing_list);
	}
 	$dom = new \DomDocument();
 	libxml_use_internal_errors(true);
    $dom->loadHtml($editor_text, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
    $images = $dom->getElementsByTagName('img');

    $rand = rand(00000000,99999999);
    foreach($images as $k => $img) {
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
}