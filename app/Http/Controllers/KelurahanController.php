<?php

namespace App\Http\Controllers;

use App\Imports\MainImport;
use App\Kelurahan;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    public function getKelurahan()
    {
        $kelurahans = Kelurahan::orderBy("gab","desc")->paginate(100);
        return view("dashboard.kelurahan",compact(["kelurahans"]));
    }

    public function importKelurahan(Request $request)
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
                'public/kelurahan',
                $filenameSave,
                'local'
            );

            // Excel::import(new OdpImport,public_path('/storage/odp/'.$filenameSave));
            $import = new MainImport();
            $import->import(public_path('/storage/kelurahan/'.$filenameSave));

            return redirect()->back()->with("success","Berhasil mengimport data");
        }



    }
}
