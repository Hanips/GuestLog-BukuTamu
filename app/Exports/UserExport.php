<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Contoh filter: hanya mengambil user dengan role 'Staff'
        $users = User::all();

        // Menambahkan nomor urut
        $users->each(function($user, $key) {
            $user->no = $key + 1;
        });

        // Memilih kolom yang ingin diekspor
        return $users->map(function($user) {
            return [
                'No' => $user->no,
                'Nama' => $user->name,
                'Email' => $user->email,
                'Role' => $user->role,
                'Created At' => $user->created_at->format('Y-m-d H:i:s')
            ];
        });
    }

    public function headings(): array
    {
        return ["No", "Nama", "Email", "Role", "created_at"];
    }
}
