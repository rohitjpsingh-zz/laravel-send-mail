<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Model_mailing extends Model
{
    protected $table = 'send_mail';
    public $timestamps = false;


    public function insert_mailing($request) {

        $mail_details = new Model_mailing();
        $mail_details->email = $request->email;
        $mail_details->description = $request->description;
        $mail_details->subject = $request->subject;
        $mail_details->sender_email = $request->sender_email;
        $mail_details->sender_fullname = $request->sender_fullname;
        $mail_details->reply_to_email = $request->reply_to_email;
        $mail_details->reply_to_fullname = $request->reply_to_fullname;
        $mail_details->charset = $request->charset;
        $mail_details->line_feed_after = $request->line_feed_after;
        $mail_details->format = $request->format;
        $mail_details->measure_open_rate = $request->measure_open_rate;
        $mail_details->editor_text = $request->editor_text;
        $mail_details->template = $request->template;
        $mail_details->mailing_list = $request->mailing_list;
        $mail_details->email_by_broadcastname = json_encode($request->get_email_cmpgn);
        
        $mail_details->save();
		//return $mail_details;
        $save_details['id'] = $mail_details->id;
       
        $last_id = $mail_details->id;
        
        return $save_details;
    }

    public function getAllsendmail($last_insert_id) {
        
        $getAllsendmail = Model_mailing::where('id', $last_insert_id)->get();
        return $getAllsendmail;
    }
}
