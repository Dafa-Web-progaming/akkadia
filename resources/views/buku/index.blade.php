@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Buku</h3>
    <!-- Tombol ini sekarang memanggil modal dengan id #modalTambahBuku -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBuku">
        + Tambah Buku
    </button>
</div>

{{-- Tambahkan blok ini untuk menampilkan error validasi jika form gagal disubmit --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Req #4: Fitur Search dan Filter Kategori -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('buku.index') }}" method="GET" class="row g-2">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari Judul / Penulis..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="kategori_id" class="form-select">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary w-100">Cari & Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>Cover</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th class="text-center">Aksi</th> <!-- Added Header -->
            </tr>
        </thead>
        <tbody>
            @forelse($bukus as $buku)
            <tr>
                <td>
                    @if($buku->cover_path)
                        <img src="{{ Storage::url($buku->cover_path) }}" alt="Cover" width="50" class="img-thumbnail">
                    @else
                        <span class="text-muted small">No Cover</span>
                    @endif
                </td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ $buku->kategori->nama ?? '-' }}</td>
                <td>
                    <span class="badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }}">
                        {{ $buku->stok }} Tersedia
                    </span>
                </td>
                <!-- Added Action Buttons -->
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <!-- Edit Button (Passes data to JS) -->
                        <button type="button"
                                class="btn btn-sm btn-warning edit-buku-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditBuku"
                                data-id="{{ $buku->id }}"
                                data-judul="{{ $buku->judul }}"
                                data-penulis="{{ $buku->penulis }}"
                                data-kategori="{{ $buku->kategori_id }}"
                                data-stok="{{ $buku->stok }}">
                            Edit
                        </button>

                        <!-- Delete Button (Form submission) -->
                        <form action="{{ route('buku.destroy', $buku) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data buku.</td> <!-- Changed colspan to 6 -->
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Req #4: Pagination -->
<div class="mt-3">
    {{ $bukus->links('pagination::bootstrap-5') }}
</div>

<!-- Modal Tambah Buku (Menyelesaikan Req #1 & #3) -->
<div class="modal fade" id="modalTambahBuku" tabindex="-1" aria-labelledby="modalTambahBukuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- PENTING: enctype="multipart/form-data" wajib ada untuk upload file/gambar -->
            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahBukuLabel">Tambah Buku Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penulis <span class="text-danger">*</span></label>
                        <input type="text" name="penulis" class="form-control" value="{{ old('penulis') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-control" min="0" value="{{ old('stok') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cover Buku (Opsional)</label>
                        <input type="file" name="cover" class="form-control" accept="image/png, image/jpeg, image/jpg">
                        <small class="text-muted">Format: JPG, JPEG, PNG (Maksimal 2MB)</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Buku -->
<div class="modal fade" id="modalEditBuku" tabindex="-1" aria-labelledby="modalEditBukuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditBuku" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Required for update routes in Laravel --}}

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditBukuLabel">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="edit_judul" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penulis <span class="text-danger">*</span></label>
                        <input type="text" name="penulis" id="edit_penulis" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" id="edit_kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stok" id="edit_stok" class="form-control" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ubah Cover Buku (Opsional)</label>
                        <input type="file" name="cover" class="form-control" accept="image/png, image/jpeg, image/jpg">
                        <small class="text-muted">Format: JPG, JPEG, PNG (Kosongkan jika tidak ingin mengubah cover)</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script to capture data parameters and dynamically update the Edit Modal form action --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-buku-btn');
        const editForm = document.getElementById('formEditBuku');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Get data variables from button attributes
                const id = this.getAttribute('data-id');
                const judul = this.getAttribute('data-judul');
                const penulis = this.getAttribute('data-penulis');
                const kategoriId = this.getAttribute('data-kategori');
                const stok = this.getAttribute('data-stok');

                // Dynamically update the form action URL to point to /buku/{id}
                editForm.action = `/buku/${id}`;

                // Set values to the inputs inside the modal
                document.getElementById('edit_judul').value = judul;
                document.getElementById('edit_penulis').value = penulis;
                document.getElementById('edit_kategori_id').value = kategoriId;
                document.getElementById('edit_stok').value = stok;
            });
        });
    });
</script>
@endsection
