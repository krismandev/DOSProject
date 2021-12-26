<?php

namespace App\Imports;

use App\Odp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;

class OdpImport implements ToModel, WithStartRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // if (strpos($row[2],"ODP")) {
            if (!Odp::where("nama_odp",$row[2])->exists()) {
                return new Odp([
                    "nama_odp"=>$row[2],
                    "sto"=>$row[3],
                    "lat"=>$row[4],
                    "long"=>$row[5],
                    "long"=>$row[5],
                    "alamat"=>$row[6],
                    "merk_olt"=>$row[7],
                    "tanggal_go_live"=>$row[8],
                    "project"=>$row[10],
                    "id_valins"=>$row[11],
                    "label_barcode_odp"=>$row[12],
                    "mitra"=>$row[13],
                    "kendala"=>$row[14],
                    "permintaan"=>$row[15]
                ]);
            }else{
                $odp = Odp::where("nama_odp",$row[2])->first();
                $odp->update([
                    "nama_odp"=>$row[2],
                    "sto"=>$row[3],
                    "lat"=>$row[4],
                    "long"=>$row[5],
                    "long"=>$row[5],
                    "alamat"=>$row[6],
                    "merk_olt"=>$row[7],
                    "tanggal_go_live"=>$row[8],
                    "project"=>$row[10],
                    "id_valins"=>$row[11],
                    "label_barcode_odp"=>$row[12],
                    "mitra"=>$row[13],
                    "kendala"=>$row[14],
                    "permintaan"=>$row[15]
                ]);
                // return $odp;
            }
        // }
    }

    // public function sheets(): array
    // {
    //     return [
    //         new FirstSheetImport()
    //     ];
    // }

    public function startRow(): int
    {
        return 2;
    }

    // public function rules(): array
    // {
    //     return [
    //         'file' => 'required|mimeTypes:'.
    //             'application/vnd.ms-office,'.
    //             'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,'.
    //             'application/vnd.ms-excel',
    //     ];
    // }
}
