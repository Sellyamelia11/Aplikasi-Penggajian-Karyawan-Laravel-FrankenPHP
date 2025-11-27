<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    private $bulan_list = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    private function validDecimal($value, $field)
    {
        if (!is_numeric($value)) {
            return "error: $field harus berupa angka";
        }

        $value = round((float)$value, 2);

        if ($value < 0) {
            return "error: $field tidak boleh negatif";
        }

        if ($value > 9999999999.99) {
            return "error: $field terlalu besar";
        }

        return $value;
    }

    // LIST
    public function index()
    {
        $gaji = Gaji::with('karyawan')->orderBy('id_gaji', 'desc')->get();
        $karyawan = Karyawan::orderBy('nama')->get();

        return view('gaji.v_gaji', compact('gaji', 'karyawan'));
    }

    // GET SATU DATA
    public function show($id_gaji)
    {
        $gaji = Gaji::with('karyawan')->find($id_gaji);

        if (!$gaji) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'error: Data tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $gaji
        ]);
    }

    // TAMBAH GAJI
    public function store(Request $r)
    {
        $id_karyawan = (int) $r->id_karyawan;
        $bulan       = trim($r->bulan);
        $tahun       = (int) $r->tahun;

        $gaji_pokok  = str_replace(',', '.', $r->gaji_pokok);
        $tunjangan   = str_replace(',', '.', $r->tunjangan);
        $potongan    = str_replace(',', '.', $r->potongan);

        // VALIDASI INPUT
        if ($id_karyawan <= 0)
            return response()->json(['status' => 'error', 'msg' => "error: Pilih karyawan"]);

        if (!in_array($bulan, $this->bulan_list))
            return response()->json(['status' => 'error', 'msg' => "error: Bulan tidak valid"]);

        if ($tahun < 2000 || $tahun > 2100)
            return response()->json(['status' => 'error', 'msg' => "error: Tahun tidak valid"]);

        // DECIMAL VALIDATION
        $gaji_pokok = $this->validDecimal($gaji_pokok, "Gaji Pokok");
        if (is_string($gaji_pokok)) return response()->json(['status' => 'error', 'msg' => $gaji_pokok]);

        $tunjangan = $this->validDecimal($tunjangan, "Tunjangan");
        if (is_string($tunjangan)) return response()->json(['status' => 'error', 'msg' => $tunjangan]);

        $potongan = $this->validDecimal($potongan, "Potongan");
        if (is_string($potongan)) return response()->json(['status' => 'error', 'msg' => $potongan]);

        $total_gaji = round(max(0, $gaji_pokok + $tunjangan - $potongan), 2);

        // CEK KARYAWAN
        if (!Karyawan::where('id', $id_karyawan)->exists()) {
            return response()->json(['status' => 'error', 'msg' => "error: Karyawan tidak ditemukan"]);
        }


        // CEK DUPLIKAT
        $duplikat = Gaji::where('id_karyawan', $id_karyawan)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->exists();

        if ($duplikat)
            return response()->json(['status' => 'error', 'msg' => "error: Gaji untuk periode ini sudah ada"]);

        // INSERT
        Gaji::create([
            'id_karyawan' => $id_karyawan,
            'bulan'       => $bulan,
            'tahun'       => $tahun,
            'gaji_pokok'  => $gaji_pokok,
            'tunjangan'   => $tunjangan,
            'potongan'    => $potongan,
            'total_gaji'  => $total_gaji,
        ]);

        return response()->json([
            'status' => 'success',
            'msg'    => 'Data Berhasil di Tambahkan!'
        ]);
    }

    // EDIT GAJI
    public function update(Request $r, $id_gaji)
    {
        $gaji = Gaji::find($id_gaji);

        if (!$gaji)
            return response()->json(['status' => 'error', 'msg' => "error: Gaji tidak ditemukan"]);

        $bulan      = trim($r->bulan);
        $tahun      = (int) $r->tahun;

        $gaji_pokok = str_replace(',', '.', $r->gaji_pokok);
        $tunjangan  = str_replace(',', '.', $r->tunjangan);
        $potongan   = str_replace(',', '.', $r->potongan);

        if (!in_array($bulan, $this->bulan_list))
            return response()->json(['status' => 'error', 'msg' => "error: Bulan tidak valid"]);

        if ($tahun < 2000 || $tahun > 2100)
            return response()->json(['status' => 'error', 'msg' => "error: Tahun tidak valid"]);

        // DECIMAL VALIDATION
        $gaji_pokok = $this->validDecimal($gaji_pokok, "Gaji Pokok");
        if (is_string($gaji_pokok)) return response()->json(['status' => 'error', 'msg' => $gaji_pokok]);

        $tunjangan = $this->validDecimal($tunjangan, "Tunjangan");
        if (is_string($tunjangan)) return response()->json(['status' => 'error', 'msg' => $tunjangan]);

        $potongan = $this->validDecimal($potongan, "Potongan");
        if (is_string($potongan)) return response()->json(['status' => 'error', 'msg' => $potongan]);

        $total_gaji = round(max(0, $gaji_pokok + $tunjangan - $potongan), 2);

        // CEK DUPLIKAT
        $duplikat = Gaji::where('id_karyawan', $gaji->id_karyawan)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('id_gaji', '!=', $id_gaji)
            ->exists();

        if ($duplikat)
            return response()->json(['status' => 'error', 'msg' => "error: Gaji untuk periode ini sudah ada"]);

        // UPDATE
        $gaji->update([
            'bulan'      => $bulan,
            'tahun'      => $tahun,
            'gaji_pokok' => $gaji_pokok,
            'tunjangan'  => $tunjangan,
            'potongan'   => $potongan,
            'total_gaji' => $total_gaji,
        ]);

        return response()->json([
            'status' => 'success',
            'msg'    => 'Data Berhasil di Edit!'
        ]);
    }

    // DELETE
    public function destroy($id_gaji)
    {
        $gaji = Gaji::find($id_gaji);

        if (!$gaji)
            return response()->json([
                'status' => 'error',
                'msg'    => "error: Data tidak ditemukan"
            ]);

        $gaji->delete();

        return response()->json([
            'status' => 'success',
            'msg'    => 'Data Berhasil di Hapus!'
        ]);
    }
}
