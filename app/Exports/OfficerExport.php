<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OfficerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Contoh filter: hanya mengambil user dengan role 'Staff'
        $officers = User::where('role', '!=', 'Pengguna')->get();

        // Menambahkan nomor urut
        $officers->each(function($officer, $key) {
            $officer->no = $key + 1;
        });

        // Memilih kolom yang ingin diekspor
        return $officers->map(function($officer) {
            return [
                'No' => $officer->no,
                'Nama' => $officer->name,
                'Email' => $officer->email,
                'Role' => $officer->role,
                'Created At' => $officer->created_at->format('Y-m-d H:i:s')
            ];
        });
    }

    public function headings(): array
    {
        return ["No", "Nama", "Email", "Role", "created_at"];
    }
}
