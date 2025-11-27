@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto p-6">

    {{-- Tombol Navigasi --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6">
        <a href="/dashboard" class="w-full sm:w-auto text-center bg-black text-white px-5 py-2 font-semibold hover:bg-gray-800 transition rounded-sm">Kembali</a>
        <a href="/karyawan" class="w-full sm:w-auto text-center bg-white text-green-600 border border-green-600 px-5 py-2 font-semibold hover:bg-green-50 transition rounded-sm">Data Karyawan</a>
    </div>

    {{-- Card --}}
    <div class="bg-white shadow-lg w-full p-8 rounded-md">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
            <h2 class="text-lg font-bold tracking-widest text-gray-800 border-b pb-2">
                KELOLA DATA GAJI KARYAWAN
            </h2>
            <button onclick="openModalTambah()" 
                    class="bg-green-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-green-700 transition">
                + Tambah Gaji
            </button>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 border-b font-bold">
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Bulan</th>
                        <th class="py-3 px-4">Tahun</th>
                        <th class="py-3 px-4">Gaji Pokok</th>
                        <th class="py-3 px-4">Tunjangan</th>
                        <th class="py-3 px-4">Potongan</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800">
                    @foreach ($gaji as $no => $row)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-2 px-3 font-semibold">{{ $no + 1 }}</td>
                        <td class="py-2 px-3">{{ $row->karyawan->nama }}</td>
                        <td class="py-2 px-3">{{ $row->bulan }}</td>
                        <td class="py-2 px-3">{{ $row->tahun }}</td>
                        <td class="py-2 px-3">Rp. {{ number_format($row->gaji_pokok,2,',','.') }}</td>
                        <td class="py-2 px-3">Rp. {{ number_format($row->tunjangan,2,',','.') }}</td>
                        <td class="py-2 px-3">Rp. {{ number_format($row->potongan,2,',','.') }}</td>
                        <td class="py-2 px-3 font-semibold">Rp. {{ number_format($row->total_gaji,2,',','.') }}</td>
                        <td class="py-2 px-3 text-center">
                            <button onclick="editData({{ $row->id_gaji }})" class="text-green-600 hover:text-green-800 mx-1">
                                <i class="ri-edit-2-fill text-xl"></i>
                            </button>
                            <button onclick="hapusData({{ $row->id_gaji }})" class="text-red-600 hover:text-red-800 mx-1">
                                <i class="ri-delete-bin-5-fill text-xl"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg overflow-hidden">

        <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold">Tambah Data Gaji</div>

        <form id="formTambah" class="p-6 space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Nama Karyawan</label>
                <select name="id_karyawan" id="id_karyawan" class="border border-gray-400 rounded w-full px-3 py-2" required onchange="isiOtomatisTambah()">
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach ($karyawan as $k)
                        <option value="{{ $k->id }}" data-no="{{ $k->no_telp }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">No Telp</label>
                <input type="text" id="no_telp_tambah" class="border border-gray-400 rounded w-full px-3 py-2 bg-gray-100" readonly>
            </div>

            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="block font-semibold mb-1">Bulan</label>
                    <select name="bulan" class="border border-gray-400 rounded w-full px-3 py-2">
                        @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                            <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block font-semibold mb-1">Tahun</label>
                    <input type="number" name="tahun" min="2000" max="2100" value="{{ date('Y') }}" class="border w-full px-3 py-2">
                </div>
            </div>

            <div>
                <label class="font-semibold">Gaji Pokok</label>
                <input type="number" name="gaji_pokok" min="0" step="0.01" value="0" class="border w-full px-3 py-2">
            </div>

            <div>
                <label class="font-semibold">Tunjangan</label>
                <input type="number" name="tunjangan" min="0" step="0.01" value="0" class="border w-full px-3 py-2">
            </div>

            <div>
                <label class="font-semibold">Potongan</label>
                <input type="number" name="potongan" min="0" step="0.01" value="0" class="border w-full px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModalTambah()" class="bg-black text-white px-4 py-2 rounded-full">Kembali</button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-full">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEdit" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg overflow-hidden">

        <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold">Edit Data Gaji</div>

        <form id="formEdit" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <input type="hidden" id="edit_id_gaji" name="id_gaji">
            <input type="hidden" id="edit_id_karyawan" name="id_karyawan">

            <div>
                <label class="font-semibold">Nama Karyawan</label>
                <input type="text" id="edit_nama_karyawan" class="border w-full px-3 py-2 bg-gray-100" readonly>
            </div>

            <div>
                <label class="font-semibold">No Telp</label>
                <input type="text" id="no_telp_edit" class="border w-full px-3 py-2 bg-gray-100" readonly>
            </div>

            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="font-semibold">Bulan</label>
                    <select id="edit_bulan" name="bulan" class="border w-full px-3 py-2">
                        @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                            <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1">
                    <label class="font-semibold">Tahun</label>
                    <input type="number" id="edit_tahun" name="tahun" min="2000" max="2100" class="border w-full px-3 py-2">
                </div>
            </div>

            <div>
                <label class="font-semibold">Gaji Pokok</label>
                <input type="number" id="edit_gaji_pokok" name="gaji_pokok" min="0" step="0.01" class="border w-full px-3 py-2">
            </div>

            <div>
                <label class="font-semibold">Tunjangan</label>
                <input type="number" id="edit_tunjangan" name="tunjangan" min="0" step="0.01" class="border w-full px-3 py-2">
            </div>

            <div>
                <label class="font-semibold">Potongan</label>
                <input type="number" id="edit_potongan" name="potongan" min="0" step="0.01" class="border w-full px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModalEdit()" class="bg-black text-white px-4 py-2 rounded-full">Kembali</button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-full">Update</button>
            </div>

        </form>
    </div>
</div>

{{-- SCRIPT --}}
<script>

function openModalTambah() {
    document.getElementById('modalTambah').classList.remove('hidden');
}
function closeModalTambah() {
    document.getElementById('modalTambah').classList.add('hidden');
}

function isiOtomatisTambah() {
    const opt = document.querySelector("#id_karyawan option:checked");
    document.getElementById("no_telp_tambah").value = opt.dataset.no ?? "";
}

function closeModalEdit() {
    document.getElementById('modalEdit').classList.add('hidden');
}

function editData(id) {
    fetch(`/gaji/${id}`)
        .then(res => res.json())
        .then(res => {
            if (res.status !== "success") {
                alert(res.msg);
                return;
            }
            openEditModal(res.data);
        })
        .catch(err => {
            alert("Gagal mengambil data!");
        });
}

function openEditModal(g) {

    document.getElementById('edit_id_gaji').value = g.id_gaji;
    document.getElementById('edit_id_karyawan').value = g.id_karyawan;

    document.getElementById('edit_nama_karyawan').value = g.karyawan.nama;
    document.getElementById('no_telp_edit').value = g.karyawan.no_telp;

    document.getElementById('edit_bulan').value = g.bulan;
    document.getElementById('edit_tahun').value = g.tahun;

    document.getElementById('edit_gaji_pokok').value = g.gaji_pokok;
    document.getElementById('edit_tunjangan').value = g.tunjangan;
    document.getElementById('edit_potongan').value = g.potongan;

    document.getElementById('modalEdit').classList.remove('hidden');
}

document.getElementById('formTambah').onsubmit = e => {
    e.preventDefault();
    let form = new FormData(e.target);

    fetch("{{ route('gaji.store') }}", { 
            method: "POST", 
            body: form 
        })
        .then(res => res.json())
        .then(resp => {
            alert(resp.msg);
            if (resp.status === "success") location.reload();
        });
};

document.getElementById('formEdit').onsubmit = e => {
    e.preventDefault();

    let id = document.getElementById('edit_id_gaji').value;

    let form = new FormData(e.target);
    form.append("_method", "PUT"); 

    fetch(`/gaji/${id}`, {
            method: "POST",
            body: form
        })
        .then(res => res.json())
        .then(resp => {
            alert(resp.msg);
            if (resp.status === "success") location.reload();
        });
};

function hapusData(id) {
    if (!confirm("Hapus data ini?")) return;

    let form = new FormData();
    form.append("_token", "{{ csrf_token() }}");
    form.append("_method", "DELETE");

    fetch(`/gaji/${id}`, { method: "POST", body: form })
        .then(res => res.json())
        .then(resp => {
            alert(resp.msg);
            if (resp.status === "success") location.reload();
        });
}

</script>
@endsection
