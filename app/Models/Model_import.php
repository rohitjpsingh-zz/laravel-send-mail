<?php

namespace App\Models;

use App\Jobs\ProcessCsvUpload;
use Illuminate\Database\Eloquent\Model;

class Model_import extends Model
{
    protected $table = 'importcsv';
    protected $fillable = ['broadcast_name','inputfile'];

    public function insert_importcsv($broadcast_name,$inputfile) {
        $user_details = new Model_import();
        $user_details->broadcast_name = $broadcast_name;
        $user_details->inputfile = $inputfile;
        $user_details->save();
        $last_id = $user_details->id;
        return $last_id;
    }

    public function getAllimport() {
        $getAllimport = Model_import::get();
        return $getAllimport;
    }

    public function getBroadcastName($broadId){
        $getAllimport = Model_import::where('id', $broadId)->get();
        return $getAllimport;
    }
}


