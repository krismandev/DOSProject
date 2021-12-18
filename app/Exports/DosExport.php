<?php

namespace App\Exports;

use App\Dos;
use Maatwebsite\Excel\Concerns\FromCollection;

class DosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Dos::all();
    }
}
