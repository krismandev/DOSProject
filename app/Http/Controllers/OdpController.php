<?php

namespace App\Http\Controllers;

use App\Imports\OdpImport;
use App\Odp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class OdpController extends Controller
{
    public function getOdp()
    {
        $odps = Odp::orderBy("nama_odp")->paginate(100);
        return view("dashboard.odp",compact(["odps"]));
    }

    public function importOdp(Request $request)
    {
        $request->validate([
            "file"=> 'required|mimes:csv,xls,xlsx'
        ]);

        // $validator = Validator::make(
        //     [
        //         'file'      => $request->file("fileodp"),
        //         'extension' => strtolower($request->file("fileodp")->getClientOriginalExtension()),
        //     ],
        //     [
        //         'file'          => 'required',
        //         'extension'      => 'required|in:xlsx,xls',
        //     ]

        // );

        // $validator = Validator::make(
        //     [
        //         'file'      => $request->file,
        //         'extension' => strtolower($request->file->getClientOriginalExtension()),
        //     ],
        //     [
        //         'file'          => 'required',
        //         'extension'      => 'required|in:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp',
        //     ]
        // );

        // if ($validator->fails()) {
        //     return back()
        //                ->withErrors($validator);
        //   }

        // $file = $request->fileodp;
        // dd($file);

        ini_set('max_execution_time', 10000);
        if ($request->has("file")) {
            $filenameWithExt = $request->file("file")->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file("file")->getClientOriginalExtension();
            $filenameSave = $filename.'_'.time().'.'.$extension;

            $filepath = $request->file('file')->storeAs(
                'public/odp',
                $filenameSave,
                'local'
            );

            Excel::import(new OdpImport,public_path('/storage/odp/'.$filenameSave));

            return redirect()->back()->with("success","Berhasil mengimport data");
        }



    }
}
