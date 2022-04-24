<?php

namespace App\Imports;

use App\Kelurahan;
use App\Odp;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KelurahanImport implements ToModel, WithStartRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // if (strpos($row[2],"ODP")) {
            if ($row[0] != null || $row[0] != "") {
                // dd($row);
                if (!Kelurahan::where("gab",$row[3])->exists()) {
                    $kelurahan = new Kelurahan([
                        "kelurahan"=>$row[0],
                        "kecamatan"=>$row[1],
                        "kabupaten"=>$row[2],
                        "gab"=>$row[3],
                        "sto"=>$row[4]
                    ]);

                    return $kelurahan;

                }else{
                    $kelurahan = Kelurahan::where("gab",$row[3])->first();

                    $kelurahan->update([
                        "kelurahan"=>$row[0],
                        "kecamatan"=>$row[1],
                        "kabupaten"=>$row[2],
                        "gab"=>$row[3],
                        "sto"=>$row[4]
                    ]);
                    // return $odp;
                }
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

    public function beliefmedia_valid_lat($latitude) {
        return preg_match('/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/', $latitude);
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
