@extends('layouts.app')

@section('content')
    <!-- Custom Styles: Tema Dark Navy (Midnight) -->
    <style>
        :root {
            --bg-card-dark: rgba(15, 23, 42, 0.85);
            --border-dark: rgba(255, 255, 255, 0.08);
            --input-dark: #0f172a;
            --border-input: #334155;
            --accent-blue: #3b82f6;
        }

        body {
            background: radial-gradient(circle at top right, #1e293b 0%, #0f172a 60%, #020617 100%) !important;
            color: #f8fafc !important;
            min-height: 100vh;
        }

        /* Modern Card */
        .dark-card {
            background: var(--bg-card-dark);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-dark);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        /* Form Controls */
        .form-control-dark,
        .form-select-dark {
            background-color: var(--input-dark) !important;
            border: 1px solid var(--border-input) !important;
            color: #f8fafc !important;
            border-radius: 12px;
            padding: 0.65rem 1rem;
            transition: all 0.2s ease;
        }

        .form-control-dark:focus,
        .form-select-dark:focus {
            border-color: var(--accent-blue) !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2) !important;
            color: #ffffff !important;
        }

        /* Primary Glowing Button */
        .btn-glow-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #ffffff;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.65rem 1.25rem;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
        }

        .btn-glow-primary:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5);
            color: #ffffff;
        }

        /* Custom Table Styling */
        .table-dark-custom {
            --bs-table-bg: transparent;
            --bs-table-color: #cbd5e1;
            --bs-table-hover-bg: rgba(30, 41, 59, 0.7);
        }

        .table-dark-custom th {
            background-color: rgba(30, 41, 59, 0.8);
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1px solid #334155;
            padding: 1rem;
        }

        .table-dark-custom td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1rem;
            vertical-align: middle;
        }

        /* Custom Badges */
        .badge-stock-success {
            background-color: rgba(34, 197, 94, 0.15);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.3);
            padding: 0.4em 0.8em;
            border-radius: 8px;
            font-weight: 500;
        }

        .badge-stock-danger {
            background-color: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 0.4em 0.8em;
            border-radius: 8px;
            font-weight: 500;
        }

        /* Modal Dark Theme */
        .modal-content-dark {
            background-color: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        }

        .modal-header-dark {
            border-bottom: 1px solid #1e293b;
        }

        .modal-footer-dark {
            border-top: 1px solid #1e293b;
        }

        .img-cover-preview {
            border-radius: 8px;
            border: 1px solid #334155;
            object-fit: cover;
        }
    </style>

    <!-- Header & Title -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold mb-1 text-white d-flex align-items-center gap-2">
                <i class="bi bi-journal-bookmark-fill text-primary"></i> Daftar Buku
            </h3>
            <p class="text-secondary small mb-0">Kelola katalog dan informasi ketersediaan buku perpustakaan</p>
        </div>
        <!-- Tombol Tambah Buku -->
        <button type="button" class="btn btn-glow-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#modalTambahBuku">
            <i class="bi bi-plus-lg fs-5"></i>
            <span>Tambah Buku Baru</span>
        </button>
    </div>

    {{-- Alert Validation Errors --}}
    @if ($errors->any())
        <div
            class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25 text-danger-emphasis rounded-3 mb-4 role="alert"">
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                <span class="fw-bold">Terjadi Kesalahan Validasi:</span>
            </div>
            <ul class="mb-0 ps-4 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Req #4: Fitur Search dan Filter Kategori -->
    <div class="card dark-card mb-4 p-2">
        <div class="card-body">
            <form action="{{ route('buku.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-secondary"
                            style="border-radius: 12px 0 0 12px; background-color: #0f172a !important; border-color: #334155 !important;">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-dark"
                            style="border-radius: 0 12px 12px 0;" placeholder="Cari Judul atau Penulis..."
                            value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-secondary"
                            style="border-radius: 12px 0 0 12px; background-color: #0f172a !important; border-color: #334155 !important;">
                            <i class="bi bi-filter"></i>
                        </span>
                        <select name="kategori_id" class="form-select form-select-dark"
                            style="border-radius: 0 12px 12px 0;">
                            <option value="">-- Semua Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit"
                        class="btn btn-outline-light w-100 py-2 d-flex align-items-center justify-content-center gap-2"
                        style="border-radius: 12px; border-color: #334155;">
                        <i class="bi bi-funnel"></i>
                        <span>Cari & Filter</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card dark-card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark-custom table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Cover</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus as $buku)
                        <tr>
                            <td class="ps-4">
                                @if ($buku->cover_path)
                                    <img src="{{ Storage::url($buku->cover_path) }}" alt="Cover" width="45"
                                        height="60" class="img-cover-preview shadow-sm">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-dark text-secondary rounded"
                                        style="width: 45px; height: 60px; border: 1px dashed #334155;">
                                        <i class="bi bi-image fs-5"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-semibold text-white">{{ $buku->judul }}</td>
                            <td class="text-secondary">{{ $buku->penulis }}</td>
                            <td>
                                <span class="badge bg-dark text-info border border-info border-opacity-25 px-2 py-1">
                                    <i class="bi bi-tag-fill me-1 small"></i>{{ $buku->kategori->nama ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $buku->stok > 0 ? 'badge-stock-success' : 'badge-stock-danger' }}">
                                    <i
                                        class="bi {{ $buku->stok > 0 ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }} me-1"></i>
                                    {{ $buku->stok }} Tersedia
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button -->
                                    <button type="button"
                                        class="btn btn-sm btn-outline-warning edit-buku-btn d-inline-flex align-items-center gap-1"
                                        style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalEditBuku"
                                        data-id="{{ $buku->id }}" data-judul="{{ $buku->judul }}"
                                        data-penulis="{{ $buku->penulis }}" data-kategori="{{ $buku->kategori_id }}"
                                        data-stok="{{ $buku->stok }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('buku.destroy', $buku) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1"
                                            style="border-radius: 8px;">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-muted"></i>
                                <span>Tidak ada data buku yang ditemukan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Req #4: Pagination -->
    <div class="d-flex justify-content-end mt-4">
        {{ $bukus->links('pagination::bootstrap-5') }}
    </div>

    <!-- Modal Tambah Buku -->
    <div class="modal fade" id="modalTambahBuku" tabindex="-1" aria-labelledby="modalTambahBukuLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-dark">
                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header modal-header-dark p-3">
                        <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2"
                            id="modalTambahBukuLabel">
                            <i class="bi bi-journal-plus text-primary"></i> Tambah Buku Baru
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Judul Buku <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control form-control-dark"
                                value="{{ old('judul') }}" placeholder="Masukkan judul buku" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Penulis <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="penulis" class="form-control form-control-dark"
                                value="{{ old('penulis') }}" placeholder="Nama penulis" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Kategori <span
                                    class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select form-select-dark" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Stok Awal <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control form-control-dark" min="0"
                                value="{{ old('stok') }}" placeholder="Jumlah stok" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label text-secondary small fw-medium">Cover Buku (Opsional)</label>
                            <input type="file" name="cover" class="form-control form-control-dark"
                                accept="image/png, image/jpeg, image/jpg">
                            <small class="text-secondary font-monospace" style="font-size: 0.75rem;">Format: JPG, JPEG,
                                PNG (Maks. 2MB)</small>
                        </div>
                    </div>

                    <div class="modal-footer modal-footer-dark p-3">
                        <button type="button" class="btn btn-outline-secondary px-4" style="border-radius: 10px;"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-glow-primary px-4">Simpan Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Buku -->
    <div class="modal fade" id="modalEditBuku" tabindex="-1" aria-labelledby="modalEditBukuLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-dark">
                <form id="formEditBuku" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-header modal-header-dark p-3">
                        <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2"
                            id="modalEditBukuLabel">
                            <i class="bi bi-pencil-square text-warning"></i> Edit Data Buku
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Judul Buku <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="judul" id="edit_judul" class="form-control form-control-dark"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Penulis <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="penulis" id="edit_penulis"
                                class="form-control form-control-dark" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Kategori <span
                                    class="text-danger">*</span></label>
                            <select name="kategori_id" id="edit_kategori_id" class="form-select form-select-dark"
                                required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Stok <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="stok" id="edit_stok" class="form-control form-control-dark"
                                min="0" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label text-secondary small fw-medium">Ubah Cover Buku (Opsional)</label>
                            <input type="file" name="cover" class="form-control form-control-dark"
                                accept="image/png, image/jpeg, image/jpg">
                            <small class="text-secondary font-monospace" style="font-size: 0.75rem;">Kosongkan jika tidak
                                ingin mengubah cover</small>
                        </div>
                    </div>

                    <div class="modal-footer modal-footer-dark p-3">
                        <button type="button" class="btn btn-outline-secondary px-4" style="border-radius: 10px;"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-glow-primary px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script JS untuk Modal Edit --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-buku-btn');
            const editForm = document.getElementById('formEditBuku');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const judul = this.getAttribute('data-judul');
                    const penulis = this.getAttribute('data-penulis');
                    const kategoriId = this.getAttribute('data-kategori');
                    const stok = this.getAttribute('data-stok');

                    // Set dynamic route action URL
                    editForm.action = `/buku/${id}`;

                    // Set value ke input form
                    document.getElementById('edit_judul').value = judul;
                    document.getElementById('edit_penulis').value = penulis;
                    document.getElementById('edit_kategori_id').value = kategoriId;
                    document.getElementById('edit_stok').value = stok;
                });
            });
        });
    </script>
@endsection
