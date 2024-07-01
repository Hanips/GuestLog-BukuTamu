<?php

namespace App\Exports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuestsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Guest::all();
    }

    public function headings(): array
    {
        return ["No", "Nama", "No Telp", "Instansi", "Email", "Alamat", "Keperluan", "Waktu", "updated_at"];
    }
}
