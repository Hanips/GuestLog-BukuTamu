<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class YearController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();
        $years = Year::orderByRaw('year_status = "active" desc, updated_at desc')->select('year_name','year_status','id')->get();

        return view('year.index', compact('notifications', 'years'));
    }

    public function store(Request $request)
    {
        Log::info('Store method called');

        $validator = Validator::make($request->all(), [
            'year_name' => 'required|unique:years,year_name',
        ]);

        if ($validator->fails()) {
            Log::info('Validation failed', ['errors' => $validator->errors()->toArray()]);
            return response()->json(['errors' => $validator->errors()->toArray()], 422);
        }

        $newYearName = $request->input('year_name');

        if ($this->isDataExist($newYearName)) {
            Log::info('Data already exists');
            return response()->json(['error' => 'Data sudah ada di tabel'], 422);
        }

        try {
            $year = Year::create([
                'year_name' => $request->input('year_name'),
                'year_status' => "nonActive"
            ]);

            Notification::create([
                'notification_content' => Auth::user()->name . " " . "membuat data tahun ajaran" . " " . $request->input('year_name'),
                'notification_status' => false
            ]);

            Log::info('Data successfully created', ['year' => $year]);

            return response()->json([
                'message' => 'Data Tahun berhasil ditambahkan!',
                'data' => $year,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to save data', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function update($id)
    {
        try {
            Year::where('id', '<>', $id)->update(['year_status' => 'nonActive']);
            $year = Year::findOrFail($id);
            $year->year_status = 'active';
            $year->save();

            Notification::create([
                'notification_content' => Auth::user()->name . " " . "mengaktifkan tahun ajaran" . " " . $year->year_name,
                'notification_status' => 0
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status tahun ajaran berhasil diperbarui!',
                'year' => $year
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status tahun ajaran!'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $year = Year::find($id);
        if (!$year) {
            return response()->json(['message' => 'Data Tahun tidak ditemukan.'], 404);
        }

        try {
            $year->delete();
            Notification::create([
                'notification_content' => Auth::user()->name . " " . "menghapus data tahun ajaran" . " " . $year->year_name,
                'notification_status' => 0
            ]);

            return response()->json(['message' => 'Data Tahun berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data tahun ajaran.'], 500);
        }
    }


    public function currentYear(Request $request)
    {
        $newYearName = $request->input('year_name');

        if (!$this->isValidData($newYearName)) {
            return response()->json(['error' => 'Data yang diberikan tidak valid'], 422);
        }

        if (!$this->isDataExist($newYearName)) {
            return response()->json(['error' => 'Data tidak ditemukan di tabel'], 422);
        }

        Year::where('year_current', 'selected')->update(['year_current' => 'unSelected']);
        Year::where(['year_name' => $newYearName])->update(['year_current' => 'selected']);

        return response()->json(['message' => 'Data tahun ajaran berhasil diperbarui'], 200);
    }

    private function isValidData($yearName)
    {
        return !empty($yearName);
    }

    private function isDataExist($yearName)
    {
        return Year::where(['year_name' => $yearName])->exists();
    }
}
