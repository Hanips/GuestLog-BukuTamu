<?php

namespace App\Exports;

use App\Models\Guest;
use App\Models\Year;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuestsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $activeYearId = Year::where('year_current', 'selected')->value('id');

        $guests = Guest::select('guests.*', 'years.year_name', 'users.name')
                       ->join('years', 'guests.year_id', '=', 'years.id')
                       ->join('users', 'guests.user_id', '=', 'users.id')
                       ->where('guests.year_id', $activeYearId)
                       ->orderBy('guests.id', 'desc')
                       ->get();

        $guests->each(function($guest, $key) {
            $guest->no = $key + 1;
        });

        return $guests->map(function($guest) {
            return [
                'No' => $guest->no,
                'Nama' => $guest->nama,
                'Instansi' => $guest->instansi,
                'No Telp' => $guest->no_telp,
                'Email' => $guest->email,
                'Alamat' => $guest->alamat,
                'Keperluan' => $guest->keperluan,
                'Signature' => $guest->signature,
                'Year Name' => $guest->year_name,
                'User Name' => $guest->name,
                'Tanggal' => $guest->tgl_kunjungan,
                'Waktu Masuk' => $guest->waktu_masuk,
                'Waktu Keluar' => $guest->waktu_keluar,
                'Status' => $guest->status == 'done' ? 'Selesai' : 'Berlangsung',
                'Created At' => $guest->created_at->format('d-m-Y H:i:s'),
                'Updated At' => $guest->updated_at->format('d-m-Y H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return ["No", "Nama", "Instansi", "No Telp", "Email", "Alamat", "Keperluan", "Signature", "Tahun Ajaran", "Petugas Penerima", "Tgl Kunjungan", "Waktu Masuk", "Waktu Keluar", "Status", "created_at", "updated_at"];
    }
}
