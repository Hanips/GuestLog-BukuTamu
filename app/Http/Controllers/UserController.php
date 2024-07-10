<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\UserExport;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();
        $ar_user = User::orderBy('users.id', 'desc')->get();

        return view('user.index', compact('notifications', 'ar_user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = User::ROLES; 
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();

        return view('user.create', compact('roles', 'notifications'));
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
            $user = User::create(
            [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password,
                'role'=>$request->role,
            ]);

            Notification::create([
                'notification_content' => Auth::user()->name . " " . "membuat data user dengan nama" . " " . $request->name,
                'notification_status' => 0
            ]);
       
            Log::info('Data successfully created', ['user' => $user]);

            return response()->json([
                'message' => 'Data pengguna berhasil ditambahkan!',
                'data' => $user,
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

        return view('user.detail', compact('rs', 'notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = User::ROLES;
        $row = User::find($id);
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();

        return view('user.edit',compact('row', 'roles', 'notifications'));
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
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            $user->save();

            Notification::create([
                'notification_content' => Auth::user()->name . " " . "mengedit data user dengan nama" . " " . $user->name,
                'notification_status' => 0
            ]);

            Log::info('Data successfully created', ['user' => $user]);

            return response()->json([
                'message' => 'Data pengguna berhasil diubah!',
                'data' => $user,
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
            $user = User::findOrFail($id);
            $user->delete();
    
            Notification::create([
                'notification_content' => Auth::user()->name . " " . "menghapus data user dengan nama" . " " . $user->name,
                'notification_status' => 0
            ]);
    
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus pengguna.'], 500);
        }
    }
    

    public function userExcel()
    {
        return Excel::download(new UserExport, 'user_'.date('d-m-Y').'.xlsx');
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $rs = User::find($id);
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();

        return view('profile.profile', compact('rs', 'notifications'));
    }

    public function editProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $roles = User::ROLES;
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();
    
        return view('profile.edit_profile', compact('user', 'roles', 'notifications'));
    }
    
    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
    
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);
    
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
    
        return response()->json(['message' => 'Profil berhasil diperbarui']);
    }
    
    public function editPassword()
    {
        $id = Auth::user()->id;
        $notifications = Notification::orderByRaw("CASE WHEN notification_status = 0 THEN 0 ELSE 1 END, updated_at DESC")->limit(10)->get();
    
        return view('profile.change_password', compact('notifications'));
    }
    
    public function updatePassword(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
    
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
    
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }
    
        $user->password = Hash::make($request->input('new_password'));
        $user->save();
    
        return response()->json(['message' => 'Password berhasil diubah']);
    }
}
