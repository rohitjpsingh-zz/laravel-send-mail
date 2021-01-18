<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use \App\Mail\SendMail;


class MailSendController extends Controller {

    public function mailsend() {
        $details = [
			'subject' => 'Testing',
			'title' => '',
			'body' => 'Regards,',
			'body1' => 'Customer Service Team',
			'body2'=>'In case you do not wish to received such communication in future, please use this link to [UNSUBSCRIBE] from this service.',
			'image' => 'https://onestop.company/demo/market/market/market/public/import_image/image.jpg'
		];
	   
		\Mail::to('dipaldonga28@gmail.com')->send(new \App\Mail\SendMail($details));
	   
		//dd("Email is Sent.");
		return view('sendmail')->with('details', $details)->header('Content-Type', 'text/html');
    }
}
?>