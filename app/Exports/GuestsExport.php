<?php

namespace App\Exports;

use App\Models\Guest;
use App\Models\Year;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuestsExport implements FromCollection, WithHeadings
{
    protected $guests;
    protected $yearName;
    protected $startDate;
    protected $finishDate;

    public function __construct($guests, $yearName, $startDate, $finishDate)
    {
        $this->guests = $guests;
        $this->yearName = $yearName;
        $this->startDate = $startDate;
        $this->finishDate = $finishDate;
    }

    public function collection()
    {
        $activeYearId = Year::where('year_name', $this->yearName)->value('id');

        $guests = Guest::select('guests.*', 'years.year_name', 'users.name')
                       ->join('years', 'guests.year_id', '=', 'years.id')
                       ->join('users', 'guests.user_id', '=', 'users.id')
                       ->where('guests.year_id', $activeYearId)
                       ->whereBetween('guests.tgl_kunjungan', [$this->startDate, $this->finishDate])
                       ->orderBy('guests.id', 'desc')
                       ->get();

        $guests->each(function($guest, $key) {
            $guest->no = $key + 1;
        });

        return $guests->map(function($guest) {
            return [
                'No' => $guest->no,
                'Nama' => $guest->nama,
                'NIP' => $guest->NIP,
                'Jabatan' => $guest->jabatan,
                'Instansi' => $guest->instansi,
                'No Telp' => $guest->no_telp,
                'Email' => $guest->email,
                'Alamat' => $guest->alamat,
                'Tanggal' => $guest->tgl_kunjungan,
                'Waktu Masuk' => $guest->waktu_masuk,
                'Waktu Keluar' => $guest->waktu_keluar,
                'Status' => $guest->status == 'done' ? 'Selesai' : 'Berlangsung',
                'Signature' => $guest->signature,
                'Keperluan' => $guest->keperluan,
                'Saran' => $guest->saran,
                'Year Name' => $guest->year_name,
                'User Name' => $guest->name,
                'Created At' => $guest->created_at->format('d-m-Y H:i:s'),
                'Updated At' => $guest->updated_at->format('d-m-Y H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return ["No", "Nama", "NIP", "Jabatan", "Instansi", "No Telp", "Email", "Alamat", "Tgl Kunjungan", "Waktu Masuk", "Waktu Keluar", "Status", "Signature", "Keperluan", "Saran",  "Tahun Ajaran", "Petugas Penerima", "created_at", "updated_at"];
    }
}