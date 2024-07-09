<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\UserExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ar_user = DB::table('users')
                    ->select('users.*')
                    ->orderBy('users.id', 'desc')
                    ->get();

        return view('user.index', compact('ar_user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = User::ROLES; // Ambil data role dari model User

        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //proses input tamu dari form
        $request->validate([
            'name' => 'required|max:45',
            'email' => 'required|max:45',
            'password' => 'required|max:20',
            'role' => 'required',
        ],
        //custom pesan errornya
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

        //lakukan insert data dari request form
        try{
            User::create(
            [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password,
                'role'=>$request->role,
            ]);
       
        return redirect()->route('user.index')
                        ->with('success','Data Petugas Baru Berhasil Disimpan');
        }
        catch (\Exception $e){
            //return redirect()->back()
            return redirect()->route('user.index')
                ->with('error', 'Terjadi Kesalahan Saat Input Data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rs = User::findOrFail($id);
        return view('user.detail', compact('rs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = User::ROLES;
        //tampilkan data lama di form
        $row = User::find($id);
        return view('user.edit',compact('row', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //proses input tamu dari form
        $request->validate([
            'name' => 'required|max:45',
            'email' => 'required|max:45',
            'role' => 'required',
        ],
        //custom pesan errornya
        [
            'name.required'=>'Nama Wajib Diisi',
            'name.max'=>'Nama Maksimal 45 karakter',
            'email.required'=>'Email Wajib Diisi',
            'email.max'=>'Email Maksimal 45 karakter',
            'role.required'=>'Role Wajib Diisi',
        ]
        );

        try {
            // Ambil data tamu berdasarkan ID
            $user = User::findOrFail($id);

            // Update atribut-atribut data tamu
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            // Simpan perubahan ke dalam database
            $user->save();

            return redirect()->route('user.index')
                            ->with('success', 'Data Petugas Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                            ->with('error', 'Terjadi Kesalahan Saat Memperbarui Data Petugas');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')
                        ->with('success','Data Petugas Berhasil Dihapus');
    }

    public function userExcel()
    {
        return Excel::download(new UserExport, 'user_'.date('d-m-Y').'.xlsx');
    }
}
