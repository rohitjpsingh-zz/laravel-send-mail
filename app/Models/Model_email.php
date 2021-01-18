<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Model_email extends Model
{
 	protected $table = "email";
    public $timestamps = false;

    public function insert_email($email, $insert_brodcast) {
        $user_details = new Model_email();
        $user_details->bid = $insert_brodcast;
        $user_details->email = $email;
        $user_details->save();
        return TRUE;
    }

    public function getAllemail($bid) {
        $getAllemail = Model_email::where('bid', $bid)->get();
        return $getAllemail;
    }
}
