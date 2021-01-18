<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Models\Model_import;
use App\Models\Model_email;
use DataTables;
use DB;
use Excel;

class ImportController extends Controller {

    public function __construct() {
        $this->import = new Model_import();
        $this->model_email = new Model_email();
    }

    public function index() {
        return view('import');
    }

    public function create() {
        //return view('import.create');
    }

    public function store(Request $request) {

        $this->validate($request, [
            'broadcast_name' => 'required',
            'inputfile' => 'required'
        ]);

        $broadcast_name = $request->broadcast_name;
        if ($request->hasfile('inputfile')) {
            $getfiledata = $request->file('inputfile');
            $extension = $getfiledata->getClientOriginalExtension(); //getting file extension
            $filename = date("Y_m_d_H_i_s") . '_' . time() . '.' . $extension;
            Storage::disk('local')->put('import_csv_file/' . $filename, File::get($getfiledata));

            $insert_brodcast = $this->import->insert_importcsv($broadcast_name, $filename);

            $fieldsdata = array();

            foreach (file(base_path('storage/app/import_csv_file') . '/' . $filename) as $line) {
                $line = trim($line);
                $linedata = str_replace('"', '', $line);

                $this->model_email->insert_email($linedata, $insert_brodcast);
            } 



            //session()->flash('status', 'queued for importing');
            //return redirect("import");
        } else {
            return $request;
        }

        //return view('import')->with('import',$import);
        return redirect('import')->with('success', 'Data Successfully Inserted');
    }

    public function listImport() {
        return view('import_list');
    }

    public function importList(Request $request) {
        $importlist = $this->import->getAllimport();
        $finaldata = array();

        $number = 1;
        foreach ($importlist as $importlistkey => $importlistdata) {
            $srno = $number;
            $importid = $importlistdata['id'];
            $broadcast_name = $importlistdata['broadcast_name'];
            $inputfile = $importlistdata['inputfile'];
            $action = "<center><button class='btn btn-danger deleteUser' onclick='deleteImport($importid)' data-userid='$importlistdata->id'><i class='fas fa-times'></i></button></center>";

            $finaldata[] = array($srno, $broadcast_name, $inputfile, $action);
            $number++;
        }
        $data['data'] = $finaldata;
        return json_encode($data);
    }
    
    public function deleteImport(Request $request) {
        $importid = $request->import_id;
        $import = $this->import::where('id', $importid)->delete();
        return redirect('/import-list')->with('success', 'Applicant Removed');
    }

}
