<?php

namespace App\Imports;

use App\Odc;
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
            if ($row[2] != null || $row[2] != "") {
                if (!Odp::where("nama_odp",$row[2])->exists()) {
                    $date = intval($row[8]);
                    $odp = new Odp([
                        "nama_odp"=>$row[2],
                        "sto"=>$row[3],
                        // "lat"=>$row[4],
                        "lat"=>preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', $row[4]),
                        "long"=>preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', $row[5]),
                        "alamat"=>$row[6],
                        "merk_olt"=>$row[7],
                        "tanggal_go_live"=> \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date),
                        "project"=>$row[10],
                        "id_valins"=>$row[11],
                        "label_barcode_odp"=>$row[12],
                        "mitra"=>$row[13],
                        "kendala"=>$row[14],
                        "permintaan"=>$row[15]
                    ]);

                    $arr_nama_odp = explode("/",$row[2]);
                    $nama_odc = $arr_nama_odp[0];
                    $nama_odc_split = explode("-",$nama_odc);
                    $sto = $nama_odc_split[1];

                    if (!Odc::where("nama_odc",$nama_odc)->exists()) {
                        Odc::create([
                            "nama_odc"=>$nama_odc,
                            "nama_sto"=>$sto
                        ]);
                    }

                    return $odp;

                }else{
                    $odp = Odp::where("nama_odp",$row[2])->first();

                    $date = intval($row[8]);
                    $odp->update([
                        "nama_odp"=>$row[2],
                        "sto"=>$row[3],
                        // "lat"=>$row[4],
                        "lat"=>preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', $row[4]),
                        "long"=>preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', $row[5]),
                        "alamat"=>$row[6],
                        "merk_olt"=>$row[7],
                        "tanggal_go_live"=> \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date),
                        "project"=>$row[10],
                        "id_valins"=>$row[11],
                        "label_barcode_odp"=>$row[12],
                        "mitra"=>$row[13],
                        "kendala"=>$row[14],
                        "permintaan"=>$row[15]
                    ]);

                    $arr_nama_odp = explode("/",$row[2]);
                    $nama_odc = $arr_nama_odp[0];
                    $nama_odc_split = explode("-",$nama_odc);
                    $sto = $nama_odc_split[1];

                    if (!Odc::where("nama_odc",$nama_odc)->exists()) {
                        Odc::create([
                            "nama_odc"=>$nama_odc,
                            "nama_sto"=>$sto
                        ]);
                    }
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
