@extends('layouts.app')

@section('content')
<div class="w-full max-w-6xl mx-auto">

    {{-- Tombol Navigasi --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6">
        <a href="/dashboard" class="w-full sm:w-auto text-center bg-black text-white px-5 py-2 font-semibold hover:bg-gray-800 transition rounded-sm">Kembali</a>
        <a href="/gaji" class="w-full sm:w-auto text-center bg-white text-green-600 border border-green-600 px-5 py-2 font-semibold hover:bg-green-50 transition rounded-sm">Gaji Karyawan</a>
    </div>

    {{-- Card --}}
    <div class="bg-white shadow-lg w-full p-8 rounded-md">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
            <h2 class="text-lg font-bold tracking-widest text-gray-800 border-b pb-2">
                KELOLA DATA KARYAWAN
            </h2>
            <button onclick="openModalTambah()" 
                    class="bg-green-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-green-700 transition">
                + Tambah Karyawan
            </button>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 border-b font-bold">
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Jabatan</th>
                        <th class="py-3 px-4">Alamat</th>
                        <th class="py-3 px-4">No Telp</th>
                        <th class="py-3 px-4 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800">
                    @foreach ($karyawan as $no => $row)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-2 px-3 font-semibold">{{ $no + 1 }}</td>
                            <td class="py-2 px-3">{{ $row->nama }}</td>
                            <td class="py-2 px-3">{{ $row->jabatan }}</td>
                            <td class="py-2 px-3">{{ $row->alamat }}</td>
                            <td class="py-2 px-3">{{ $row->no_telp }}</td>
                            <td class="py-2 px-3 text-center">
                                <button 
                                    onclick="editData({{ $row->id }})"
                                    class="text-green-600 hover:text-green-800 mx-1">
                                    <i class="ri-edit-2-fill text-xl"></i>
                                </button>

                                <button onclick="hapusData({{ $row->id }})"
                                    class="text-red-600 hover:text-red-800 mx-1">
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

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md rounded-xl shadow-xl">

        <div class="bg-green-600 text-white text-center py-3 rounded-t-xl text-lg font-semibold shadow-md shadow-green-300">
            Tambah Data Karyawan
        </div>

        <form id="formTambah" class="p-6 space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Nama</label>
                <input type="text" name="nama"
                    class="border border-green-400 rounded w-full px-3 py-2 focus:ring-green-500" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Jabatan</label>
                <input type="text" name="jabatan"
                    class="border border-green-400 rounded w-full px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Alamat</label>
                <input type="text" name="alamat"
                    class="border border-green-400 rounded w-full px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">No Telp</label>
                <input type="text" name="no_telp"
                    class="border border-green-400 rounded w-full px-3 py-2" required>
            </div>

            <div class="flex justify-end space-x-3 mt-2">
                <button type="button" onclick="closeModalTambah()"
                    class="px-4 py-2 bg-black text-white rounded-full font-semibold">Kembali</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-full">Simpan</button>
            </div>

        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="hidden fixed inset-0 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md shadow-xl">

        <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold">
            Edit Data Karyawan
        </div>

        <form id="formEdit" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="id" id="edit_id">

            <div>
                <label class="block font-semibold mb-1">Nama</label>
                <input type="text" id="edit_nama" name="nama"
                    class="border border-green-400 rounded w-full px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Jabatan</label>
                <input type="text" id="edit_jabatan" name="jabatan"
                    class="border border-green-400 rounded w-full px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Alamat</label>
                <input type="text" id="edit_alamat" name="alamat"
                    class="border border-green-400 rounded w-full px-3 py-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">No Telp</label>
                <input type="text" id="edit_no_telp" name="no_telp"
                    class="border border-green-400 rounded w-full px-3 py-2" required>
            </div>

            <div class="flex justify-end space-x-3 mt-2">
                <button type="button" onclick="closeModalEdit()"
                    class="px-4 py-2 bg-black text-white rounded-full">Kembali</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-full">
                    Update
                </button>
            </div>
        </form>

    </div>
</div>

<script>

function openModalTambah() { document.getElementById('modalTambah').classList.remove('hidden'); }
function closeModalTambah() { document.getElementById('modalTambah').classList.add('hidden'); }

function openModalEdit() { document.getElementById('modalEdit').classList.remove('hidden'); }
function closeModalEdit() { document.getElementById('modalEdit').classList.add('hidden'); }

// EDIT DATA
function editData(id) {

    fetch("{{ url('/karyawan') }}/" + id)
        .then(res => res.json())
        .then(data => {

            if (data.message === "Data tidak ditemukan") {
                alert("Data tidak ditemukan");
                return;
            }

            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_nama').value = data.nama;
            document.getElementById('edit_jabatan').value = data.jabatan;
            document.getElementById('edit_alamat').value = data.alamat;
            document.getElementById('edit_no_telp').value = data.no_telp;

            openModalEdit();
        })
        .catch(err => {
            alert("Gagal mengambil data.");
            console.error(err);
        });
}

// TAMBAH DATA
document.getElementById('formTambah').addEventListener('submit', function (e) {
    e.preventDefault();

    let form = new FormData(this);

    fetch("{{ route('karyawan.store') }}", {
        method: "POST",
        headers: {
            "Accept": "application/json"
        },
        body: form
    })
    .then(async res => {

        // VALIDASI ERROR (422)
        if (res.status === 422) {
            const err = await res.json();
            const firstError = Object.values(err.errors)[0][0];
            alert(firstError);
            return;
        }

        // ERROR LAIN (400,404,500)
        if (!res.ok) {
            const err = await res.json();
            alert(err.message || "Terjadi kesalahan.");
            return;
        }

        // SUCCESS
        const resp = await res.json();
        alert(resp.message);

        if (resp.status === "success") location.reload();
    })
    .catch(() => alert("Terjadi kesalahan."));
});



// EDIT DATA
document.getElementById('formEdit').addEventListener('submit', function (e) {
    e.preventDefault();

    let id = document.getElementById('edit_id').value;
    let form = new FormData(this);
    form.append("_method", "PUT");

    fetch("{{ url('/karyawan') }}/" + id, {
        method: "POST",
        headers: {
            "Accept": "application/json"
        },
        body: form
    })
    .then(async res => {

        // VALIDASI ERROR
        if (res.status === 422) {
            const err = await res.json();
            const firstError = Object.values(err.errors)[0][0];
            alert(firstError);
            return;
        }

        // ERROR LAIN
        if (!res.ok) {
            const err = await res.json();
            alert(err.message || "Terjadi kesalahan.");
            return;
        }

        // SUCCESS
        const resp = await res.json();
        alert(resp.message);

        if (resp.status === "success") location.reload();
    })
    .catch(() => alert("Terjadi kesalahan."));
});

// HAPUS DATA
function hapusData(id) {
    if (!confirm("Yakin ingin menghapus data ini?")) return;

    let form = new FormData();
    form.append("_method", "DELETE");
    form.append("_token", "{{ csrf_token() }}");

    fetch("{{ url('/karyawan') }}/" + id, {
        method: "POST",
        body: form
    })
    .then(async res => {
        const resp = await res.json();
        alert(resp.message);

        if (resp.status === "success") location.reload();
    });
}

</script>
@endsection
