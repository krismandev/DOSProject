<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MainImport implements WithMultipleSheets
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function sheets(): array
    {
        return [
            0 => new OdpImport()
        ];
    }
}
