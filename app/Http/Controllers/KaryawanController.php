<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    // LIST DATA
    public function index()
    {
        $karyawan = Karyawan::orderBy('id', 'desc')->get();
        return view('karyawan.v_karyawan', compact('karyawan'));
    }

    // TAMBAH DATA
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string',
            'jabatan'  => 'required|string',
            'alamat'   => 'required|string',
            'no_telp'  => [
                'required',
                'regex:/^628\d{7,10}$/',
                'unique:data_karyawan,no_telp'
            ],
        ]);

        Karyawan::create($request->only('nama', 'jabatan', 'alamat', 'no_telp'));
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan'
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string',
            'jabatan'  => 'required|string',
            'alamat'   => 'required|string',
            'no_telp'  => [
                'required',
                'regex:/^628\d{7,10}$/',
                Rule::unique('data_karyawan', 'no_telp')->ignore($karyawan->id)
            ],
        ]);

        $karyawan->update($request->only('nama', 'jabatan', 'alamat', 'no_telp'));
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diupdate'
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        Karyawan::findOrFail($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
