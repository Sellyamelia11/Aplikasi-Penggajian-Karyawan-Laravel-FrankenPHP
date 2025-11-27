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
        $karyawan = Karyawan::orderBy('nama')->get();
        return view('karyawan.v_karyawan', compact('karyawan'));
    }

    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nama'     => ['required', 'regex:/^[A-Za-z\s.,]+$/'],
            'jabatan'  => 'required|string',
            'alamat'   => 'required|string',
            'no_telp'  => [
                'required',
                'regex:/^628\d{7,10}$/',
                'unique:data_karyawan,no_telp'
            ],
        ], [
            'nama.regex'       => 'Nama hanya boleh huruf dan tidak boleh mengandung angka!',
            'no_telp.unique'   => 'No Telp sudah digunakan!',
            'no_telp.regex'    => 'No Telp harus diawali 628 dan minimal 10 digit!'
        ]);

        // SIMPAN
        Karyawan::create([
            'nama'     => $request->nama,
            'jabatan'  => $request->jabatan,
            'alamat'   => $request->alamat,
            'no_telp'  => $request->no_telp,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data Karyawan Berhasil di Tambahkan!'
        ]);
    }

    public function show($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data karyawan tidak ditemukan'
            ], 404);
        }

        // VALIDASI UPDATE (unique tapi ignore id sendiri)
        $request->validate([
            'nama'     => ['required', 'regex:/^[A-Za-z\s.,]+$/'],
            'jabatan'  => 'required|string',
            'alamat'   => 'required|string',
            'no_telp'  => [
                'required',
                'regex:/^628\d{7,10}$/',
                Rule::unique('data_karyawan', 'no_telp')->ignore($karyawan->id)
            ],
        ], [
            'nama.regex'       => 'Nama hanya boleh huruf dan tidak boleh mengandung angka!',
            'no_telp.unique'   => 'No Telp sudah digunakan!',
            'no_telp.regex'    => 'No Telp harus diawali 628 dan minimal 10 digit!'
        ]);

        // UPDATE DATA
        $karyawan->update([
            'nama'     => $request->nama,
            'jabatan'  => $request->jabatan,
            'alamat'   => $request->alamat,
            'no_telp'  => $request->no_telp,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data karyawan Berhasil di Edit!'
        ]);
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $karyawan->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data karyawan berhasil di Hapus!'
        ]);
    }
}
