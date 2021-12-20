<?php

namespace App\Exports;

use App\Dos;
use App\SalesForce;
use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class DosExport implements FromView
{
    protected $id;
    protected $awal;
    protected $akhir;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($id,$awal,$akhir) {
        $this->id = $id;
        $this->awal = $awal;
        $this->akhir = $akhir;
        // $this->peserta_ujian = $peserta_ujian;

    }

    public function view(): View
    {
        $user_spv = User::find($this->id);
        $spv = $user_spv->spv;
        $user_sf_ids = SalesForce::where("spv_id",$spv->id)->pluck("user_id");
        $dos = Dos::whereIn("user_id",$user_sf_ids)->whereDate('created_at','>=',$this->awal)->whereDate('created_at','<=',$this->akhir)->with("user")->orderBy("created_at","desc")->get();

        return view("dashboard.dos.exportDos",[
            "dos"=>$dos
        ]);
    }
    // public function collection()
    // {
    //     return Dos::all();
    // }
}
