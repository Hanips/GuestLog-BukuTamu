<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\OfficerExport;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();

        $query = DB::table('users')
                    ->select('users.*')
                    ->where('role', 'Satpam')
                    ->orderBy('users.id', 'desc');

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $ar_officer = $query->paginate(10);

        return view('officer.index', compact('notifications', 'ar_officer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = User::ROLES;
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();

        return view('officer.create', compact('roles', 'notifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:45',
            'email' => 'required|max:45',
            'password' => 'required|max:20',
            'role' => 'required',
        ],
        [
            'name.required'=>'Nama Wajib Diisi',
            'name.max'=>'Nama Maksimal 45 karakter',
            'email.required'=>'Email Wajib Diisi',
            'email.max'=>'Email Maksimal 45 karakter',
            'password.required'=>'Password Wajib Diisi',
            'password.max'=>'Password Maksimal 20 karakter',
            'role.required'=>'Role Wajib Diisi',
        ]
        );

        try{
            $officer = User::create(
            [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password,
                'role'=>$request->role,
            ]);

        Notification::create([
            'notification_content' => Auth::user()->name . " " . "membuat data petugas dengan nama" . " " . $request->nama,
            'notification_status' => 0
        ]);
       
        Log::info('Data successfully created', ['user' => $officer]);

            return response()->json([
                'message' => 'Data petugas berhasil ditambahkan!',
                'data' => $officer,
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
        $rs = User::findOrFail($id);
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();

        return view('officer.detail', compact('rs', 'notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = User::ROLES;
        $row = User::find($id);
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();

        return view('officer.edit',compact('row', 'roles', 'notifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:45',
            'email' => 'required|max:45',
            'role' => 'required',
        ],
        [
            'name.required'=>'Nama Wajib Diisi',
            'name.max'=>'Nama Maksimal 45 karakter',
            'email.required'=>'Email Wajib Diisi',
            'email.max'=>'Email Maksimal 45 karakter',
            'role.required'=>'Role Wajib Diisi',
        ]
        );

        try {
            $officer = User::findOrFail($id);

            $officer->name = $request->name;
            $officer->email = $request->email;
            $officer->role = $request->role;

            $officer->save();

            Notification::create([
                'notification_content' => Auth::user()->name . " " . "mengedit data satpam dengan nama" . " " . $officer->nama,
                'notification_status' => 0
            ]);

            Log::info('Data successfully created', ['user' => $officer]);

            return response()->json([
                'message' => 'Data petugas berhasil diubah!',
                'data' => $officer,
            ], 201);
        
        } catch (\Exception $e) {
            Log::error('Failed to save data', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $officer = User::findOrFail($id);
            $officer->delete();
    
            Notification::create([
                'notification_content' => Auth::user()->name . " " . "menghapus data petugas dengan nama" . " " . $officer->name,
                'notification_status' => 0
            ]);
    
            return response()->json(['success' => true, 'message' => 'Petugas berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus petugas.'], 500);
        }
    }

    public function officerExcel()
    {
        return Excel::download(new OfficerExport, 'officer_'.date('d-m-Y').'.xlsx');
    }
}
