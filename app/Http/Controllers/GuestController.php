<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; //query builder
use App\Exports\GuestsExport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeYearId = Year::where('year_current', 'selected')->value('id');
        $years = Year::orderBy("updated_at", "DESC")->get();
        $ar_guest = Guest::where('year_id', $activeYearId)
                                    ->select('guests.*')
                                    ->orderBy('guests.id', 'desc')
                                    ->get();
        return view('guest.index', compact('ar_guest', 'years'));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activeYear = Year::where('year_status', 'active')->first();
        $ar_user = User::all();
        $status = Guest::STATUS; 

        //arahkan ke form input data
        return view('guest.create',compact('ar_user', 'activeYear', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //proses input tamu dari form
        $request->validate([
            'nama' => 'required|max:45',
            'instansi' => 'required|max:45',
            'no_telp' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'email' => 'required|max:45',
            'alamat' => 'required|max:45',
            'keperluan' => 'required|max:100',
            'tgl_kunjungan' => 'required',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'year_id' => 'required|integer',
            'user_id' => 'required|integer',
        ],
        //custom pesan errornya
        [
            'nama.required'=>'Nama Wajib Diisi',
            'nama.max'=>'Nama Maksimal 45 karakter',
            'instansi.required'=>'Instansi Wajib Diisi',
            'instansi.max'=>'Instansi Maksimal 45 karakter',
            'no_telp.required'=>'No Telp Wajib Diisi',
            'no_telp.regex'=>'No Telp Harus Berupa Angka',
            'email.required'=>'Email Wajib Diisi',
            'email.max'=>'Email Maksimal 45 karakter',
            'alamat.required'=>'Alamat Wajib Diisi',
            'alamat.max'=>'Alamat Maksimal 45 karakter',
            'keperluan.required'=>'Keperluan Wajib Diisi',
            'keperluan.max'=>'Keperluan Maksimal 100 karakter',
            'tgl_kunjungan' => 'Tanggal Wajib Diisi',
            'waktu_masuk' => 'Waktu Masuk Wajib Diisi',
            'waktu_keluar' => 'Waktu Keluar Wajib Diisi',
            'year_id.required'=>'Tahun Ajaran Wajib Diisi',
            'year_id.integer'=>'Tahun Ajaran Harus Berupa Angka',
            'user_id.required'=>'Petugas Wajib Diisi',
            'user_id.integer'=>'Petugas Harus Berupa Angka',
        ]
        );

        //lakukan insert data dari request form
        try{
            Guest::create(
            [
                'nama'=>$request->nama,
                'instansi'=>$request->instansi,
                'no_telp'=>$request->no_telp,
                'email'=>$request->email,
                'alamat'=>$request->alamat,
                'keperluan'=>$request->keperluan,
                'tgl_kunjungan'=>$request->tgl_kunjungan,
                'waktu_masuk'=>$request->waktu_masuk,
                'waktu_keluar'=>$request->waktu_keluar,
                'year_id'=>$request->year_id,
                'user_id'=>$request->user_id,
                'status'=>$request->status,
            ]);
       
        return redirect()->route('guest.index')
                        ->with('success','Data Tamu Baru Berhasil Disimpan');
        }
        catch (\Exception $e){
            //return redirect()->back()
            return redirect()->route('guest.index')
                ->with('error', 'Terjadi Kesalahan Saat Input Data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rs = Guest::findOrFail($id);
        return view('guest.detail', compact('rs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //tampilkan data lama di form
        $row = Guest::find($id);
        $ar_user = User::all();
        $status = Guest::STATUS; 

        //arahkan ke form input data
        return view('guest.edit',compact('row', 'ar_user', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'required|max:45',
            'instansi' => 'required|max:45',
            'no_telp' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'email' => 'required|max:45',
            'alamat' => 'required|max:45',
            'keperluan' => 'required|max:100',
            'tgl_kunjungan' => 'required',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'year_id' => 'required|integer',
            'user_id' => 'required|integer',
            'status' => 'required',
        ],
        //custom pesan errornya
        [
            'nama.required'=>'Nama Wajib Diisi',
            'nama.max'=>'Nama Maksimal 45 karakter',
            'instansi.required'=>'Instansi Wajib Diisi',
            'instansi.max'=>'Instansi Maksimal 45 karakter',
            'no_telp.required'=>'No Telp Wajib Diisi',
            'no_telp.regex'=>'No Telp Harus Berupa Angka',
            'email.required'=>'Email Wajib Diisi',
            'email.max'=>'Email Maksimal 45 karakter',
            'alamat.required'=>'Alamat Wajib Diisi',
            'alamat.max'=>'Alamat Maksimal 45 karakter',
            'keperluan.required'=>'Keperluan Wajib Diisi',
            'keperluan.max'=>'Keperluan Maksimal 100 karakter',
            'tgl_kunjungan' => 'Tanggal Wajib Diisi',
            'waktu_masuk' => 'Waktu Masuk Wajib Diisi',
            'waktu_keluar' => 'Waktu Keluar Wajib Diisi',
            'year_id.required'=>'Tahun Ajaran Wajib Diisi',
            'year_id.integer'=>'Tahun Ajaran Harus Berupa Angka',
            'user_id.required'=>'Petugas Wajib Diisi',
            'user_id.integer'=>'Petugas Harus Berupa Angka',
            'status.required'=>'Status Wajib Diisi',
        ]
        );

        try {
            // Ambil data tamu berdasarkan ID
            $guest = Guest::findOrFail($id);

            // Update atribut-atribut data tamu
            $guest->nama = $request->nama;
            $guest->instansi = $request->instansi;
            $guest->no_telp = $request->no_telp;
            $guest->email = $request->email;
            $guest->alamat = $request->alamat;
            $guest->keperluan = $request->keperluan;
            $guest->tgl_kunjungan = $request->tgl_kunjungan;
            $guest->waktu_masuk = $request->waktu_masuk;
            $guest->waktu_keluar = $request->waktu_keluar;
            $guest->year_id = $request->year_id;
            $guest->user_id = $request->user_id;
            $guest->status = $request->status;

            // Simpan perubahan ke dalam database
            $guest->save();

            return redirect()->route('guest.index')
                            ->with('success', 'Data Tamu Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->route('guest.index')
                            ->with('error', 'Terjadi Kesalahan Saat Memperbarui Data Tamu');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guest = Guest::find($id);
        $guest->delete();
        return redirect()->route('guest.index')
                        ->with('success','Data Tamu Berhasil Dihapus');
    }

    public function guestExcel()
    {
        return Excel::download(new GuestsExport, 'guests_'.date('d-m-Y').'.xlsx');
    }
}
