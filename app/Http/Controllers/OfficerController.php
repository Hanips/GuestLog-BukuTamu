<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB; //query builder

class OfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ar_officer = DB::table('users')
                ->select('users.*')
                ->orderBy('users.id', 'desc')
                ->get();
        return view('officer.index', compact('ar_officer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = User::ROLES; // Ambil data role dari model User

        return view('officer.create', compact('roles'));
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
       
        return redirect()->route('officer.index')
                        ->with('success','Data Petugas Baru Berhasil Disimpan');
        }
        catch (\Exception $e){
            //return redirect()->back()
            return redirect()->route('officer.index')
                ->with('error', 'Terjadi Kesalahan Saat Input Data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rs = User::findOrFail($id);
        return view('officer.detail', compact('rs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = User::ROLES;
        //tampilkan data lama di form
        $row = User::find($id);
        return view('officer.edit',compact('row', 'roles'));
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
            $officer = User::findOrFail($id);

            // Update atribut-atribut data tamu
            $officer->name = $request->name;
            $officer->email = $request->email;
            $officer->role = $request->role;

            // Simpan perubahan ke dalam database
            $officer->save();

            return redirect()->route('officer.index')
                            ->with('success', 'Data Petugas Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->route('officer.index')
                            ->with('error', 'Terjadi Kesalahan Saat Memperbarui Data Petugas');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $officer = User::find($id);
        $officer->delete();
        return redirect()->route('officer.index')
                        ->with('success','Data Petugas Berhasil Dihapus');
    }

    // public function officerExcel()
    // {
    //     return Excel::download(new PetugasExport, 'officer_'.date('d-m-Y').'.xlsx');
    // }
}
