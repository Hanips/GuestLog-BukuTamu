<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Year;
use Illuminate\Support\Facades\Storage;
use App\Exports\GuestsExport;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();
        $ar_guest = Guest::where('year_id', $activeYearId)
                            ->orderBy('guests.id', 'desc')
                            ->get();

        return view('guest.index', compact('notifications', 'ar_guest', 'years'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activeYear = Year::where('year_status', 'active')->first();
        $ar_user = User::all();
        $status = Guest::STATUS; 
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();

        return view('guest.create',compact('ar_user', 'activeYear', 'status', 'notifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //proses input tamu dari form
        $request->validate([
            'nama' => 'required|max:45',
            'NIP' => 'required|integer',
            'jabatan' => 'required|max:45',
            'instansi' => 'required|max:45',
            'no_telp' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'email' => 'required|max:45',
            'alamat' => 'required|max:45',
            'tgl_kunjungan' => 'required',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'signature' => 'required',
            'keperluan' => 'required|max:100',
            'saran' => 'required|max:100',
            'year_id' => 'required|integer',
            'user_id' => 'required|integer',
        ],
        //Pesan errornya
        [
            'nama.required'=>'Nama Wajib Diisi',
            'nama.max'=>'Nama Maksimal 45 karakter',
            'NIP.required'=>'NIP Wajib Diisi',
            'NIP.integer'=>'NIP Harus Berupa Angka',
            'jabatan.required'=>'Jabatan Wajib Diisi',
            'jabatan.max'=>'Jabatan Maksimal 45 karakter',
            'instansi.required'=>'Instansi Wajib Diisi',
            'instansi.max'=>'Instansi Maksimal 45 karakter',
            'no_telp.required'=>'No Telp Wajib Diisi',
            'no_telp.regex'=>'No Telp Harus Berupa Angka',
            'email.required'=>'Email Wajib Diisi',
            'email.max'=>'Email Maksimal 45 karakter',
            'alamat.required'=>'Alamat Wajib Diisi',
            'alamat.max'=>'Alamat Maksimal 45 karakter',
            'tgl_kunjungan' => 'Tanggal Wajib Diisi',
            'waktu_masuk' => 'Waktu Masuk Wajib Diisi',
            'waktu_keluar' => 'Waktu Keluar Wajib Diisi',
            'signature.required'=>'TTD Wajib Diisi',
            'keperluan.required'=>'Keperluan Wajib Diisi',
            'keperluan.max'=>'Keperluan Maksimal 100 karakter',
            'saran.required'=>'Saran Wajib Diisi',
            'saran.max'=>'Saran Maksimal 100 karakter',
        ]
        );

        //Insert data dari request form
        try{
            // simpan tanda tangan
            $signature = $request->input('signature');
            $signature = substr($signature, strpos($signature, ',') + 1);
            $filename = 'signature_' . time() . '.png';
            Storage::disk('public')->put('signatures/' . $filename, base64_decode($signature));

            $guest = Guest::create(
            [
                'nama'=>$request->nama,
                'NIP'=>$request->NIP,
                'jabatan'=>$request->jabatan,
                'instansi'=>$request->instansi,
                'no_telp'=>$request->no_telp,
                'email'=>$request->email,
                'alamat'=>$request->alamat,
                'tgl_kunjungan'=>$request->tgl_kunjungan,
                'waktu_masuk'=>$request->waktu_masuk,
                'waktu_keluar'=>$request->waktu_keluar,
                'status'=>$request->status,
                'signature' => $filename,
                'keperluan'=>$request->keperluan,
                'saran'=>$request->saran,
                'year_id'=>$request->year_id,
                'user_id'=>$request->user_id,
            ]);

            $year = Year::find($request->year_id);

            Notification::create([
                'notification_content' => Auth::user()->name . " " . "membuat data tamu dengan nama" . " " . $request->input('nama') . " " . "pada tahun ajaran" . " " . $year->year_name,
                'notification_status' => 0
            ]);
       
            Log::info('Data successfully created', ['guest' => $guest]);

            return response()->json([
                'message' => 'Data tamu berhasil ditambahkan!',
                'data' => $guest,
            ], 201);
        
        } catch (\Exception $e) {
            Log::error('Failed to save data', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rs = Guest::findOrFail($id);
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();
        
        return view('guest.detail', compact('rs', 'notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $row = Guest::find($id);
        $ar_user = User::all();
        $status = Guest::STATUS; 
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();

        return view('guest.edit',compact('row', 'ar_user', 'status', 'notifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:45',
            'NIP' => 'required|integer',
            'jabatan' => 'required|max:45',
            'instansi' => 'required|max:45',
            'no_telp' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'email' => 'required|max:45',
            'alamat' => 'required|max:45',
            'tgl_kunjungan' => 'required',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'keperluan' => 'required|max:100',
            'saran' => 'required|max:100',
            'year_id' => 'required|integer',
            'user_id' => 'required|integer',
        ],
        //Pesan errornya
        [
            'nama.required'=>'Nama Wajib Diisi',
            'nama.max'=>'Nama Maksimal 45 karakter',
            'NIP.required'=>'NIP Wajib Diisi',
            'NIP.integer'=>'NIP Harus Berupa Angka',
            'jabatan.required'=>'Jabatan Wajib Diisi',
            'jabatan.max'=>'Jabatan Maksimal 45 karakter',
            'instansi.required'=>'Instansi Wajib Diisi',
            'instansi.max'=>'Instansi Maksimal 45 karakter',
            'no_telp.required'=>'No Telp Wajib Diisi',
            'no_telp.regex'=>'No Telp Harus Berupa Angka',
            'email.required'=>'Email Wajib Diisi',
            'email.max'=>'Email Maksimal 45 karakter',
            'alamat.required'=>'Alamat Wajib Diisi',
            'alamat.max'=>'Alamat Maksimal 45 karakter',
            'tgl_kunjungan' => 'Tanggal Wajib Diisi',
            'waktu_masuk' => 'Waktu Masuk Wajib Diisi',
            'waktu_keluar' => 'Waktu Keluar Wajib Diisi',
            'keperluan.required'=>'Keperluan Wajib Diisi',
            'keperluan.max'=>'Keperluan Maksimal 100 karakter',
            'saran.required'=>'Saran Wajib Diisi',
            'saran.max'=>'Saran Maksimal 100 karakter',
        ]
        );

        try {
            $guest = Guest::findOrFail($id);

            $guest->nama = $request->nama;
            $guest->NIP = $request->NIP;
            $guest->jabatan = $request->jabatan;
            $guest->instansi = $request->instansi;
            $guest->no_telp = $request->no_telp;
            $guest->email = $request->email;
            $guest->alamat = $request->alamat;
            $guest->tgl_kunjungan = $request->tgl_kunjungan;
            $guest->waktu_masuk = $request->waktu_masuk;
            $guest->waktu_keluar = $request->waktu_keluar;
            $guest->keperluan = $request->keperluan;
            $guest->saran = $request->saran;
            $guest->year_id = $request->year_id;
            $guest->user_id = $request->user_id;
            $guest->status = $request->status;
            $guest->signature = $this->handleSignature($request, $guest);

            $guest->save();

            $year = Year::find($request->year_id);

            Notification::create([
                'notification_content' => Auth::user()->name . " " . "mengedit data tamu dengan nama" . " " . $request->input('nama') . " " . "pada tahun ajaran" . " " . $year->year_name,
                'notification_status' => 0
            ]);

            Log::info('Data successfully created', ['guest' => $guest]);

            return response()->json([
                'message' => 'Data tamu berhasil diubah!',
                'data' => $guest,
            ], 201);
        
        } catch (\Exception $e) {
            Log::error('Failed to save data', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    private function handleSignature(Request $request, $guest)
    {
        // Periksa jika ada tanda tangan baru
        if ($request->filled('signature')) {
            // Hapus tanda tangan lama jika ada
            if ($guest->signature) {
                Storage::delete('public/signatures/' . $guest->signature);
            }

            // Simpan tanda tangan baru
            $signatureData = $request->input('signature');
            $signatureFileName = $guest->id . '_signature.png';
            Storage::put('public/signatures/' . $signatureFileName, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData)));
            return $signatureFileName;
        }

        // Kembalikan tanda tangan saat ini jika tidak ada perubahan
        return $request->input('current_signature');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $guest = Guest::findOrFail($id);

            // Hapus tanda tangan dari penyimpanan jika ada
            if ($guest->signature) {
                Storage::delete('public/signatures/' . $guest->signature);
            }

            $guest->delete();

            $year = Year::find($guest->year_id);
            Notification::create([
                'notification_content' => Auth::user()->name . " menghapus data tamu dengan nama " . $guest->nama . " pada tahun ajaran " . $year->year_name,
                'notification_status' => 0
            ]);

            return response()->json(['success' => true, 'message' => 'Tamu berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus tamu.'], 500);
        }
    }

    public function guestExcel(Request $request)
    {
        $tahunAjaran = $request->input('nama_tahun');
        $startDate = $request->input('start_date');
        $endDate = $request->input('finish_date');

        $query = Guest::query();

        if ($tahunAjaran) {
            $year = Year::where('year_name', $tahunAjaran)->first();
            if ($year) {
                $query->where('year_id', $year->id);
            }
        }

        if ($startDate && $endDate) {
            $query->whereDate('tgl_kunjungan', '>=', $startDate)
                ->whereDate('tgl_kunjungan', '<=', $endDate);
        }

        $guests = $query->get();

        return Excel::download(new GuestsExport($guests, $tahunAjaran, $startDate, $endDate), 'guests_' . date('d-m-Y') . '.xlsx');
    }
}
