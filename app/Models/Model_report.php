<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Model_report extends Model
{
    protected $table = 'report';
    public $timestamps = false;

    public function insert_report($records) {

        $report_details = new Model_report();
        $report_details->bid = $records['bid'];
        $report_details->start_time = $records['start_time'];
        $report_details->end_time = $records['end_time'];
        $report_details->date = $records['date'];
        $report_details->total_mail = $records['total_mail'];
        $report_details->save();
        
        return $report_details;
    }

    public function getMailReport() {
        
        $getAllsendmail = Model_report::orderBy('rid', 'desc')->first();
        return $getAllsendmail;
    }

    public function getTotalMail($bid){
        $totalEmail = Model_report::where('bid',$bid)->orderBy('rid','DESC')->first();
        $totalEmail = $totalEmail->total_mail;

        return $totalEmail;
    }
}
