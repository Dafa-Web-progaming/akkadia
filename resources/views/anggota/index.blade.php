@extends('layouts.app')

@section('content')
    <!-- Custom Styles: Fix Layout & Tema Dark Navy -->
    <style>
        /* 1. Hanya body yang diberi background gelap dan tinggi penuh */
        html,
        body {
            background-color: #020617 !important;
            color: #f8fafc !important;
            min-height: 100vh;
        }

        /* 2. Netralkan wrapper bawaan Laravel/Bootstrap agar TIDAK ikut molor */
        #app,
        main,
        .content,
        .container,
        .container-fluid {
            background-color: transparent !important;
            min-height: auto !important;
        }

        .page-title {
            color: #f8fafc;
            font-weight: 700;
        }

        /* Card Utama Tema Dark Navy */
        .card-dark-custom {
            background-color: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        /* Tabel Tema Dark Navy */
        .table-dark-custom {
            --bs-table-bg: transparent;
            --bs-table-color: #cbd5e1;
            --bs-table-hover-bg: rgba(30, 41, 59, 0.6);
            color: #cbd5e1;
        }

        .table-dark-custom thead {
            background-color: #1e293b;
        }

        .table-dark-custom th {
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem;
            border-bottom: 1px solid #334155 !important;
        }

        .table-dark-custom td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }

        /* Tombol Utama Glowing Blue */
        .btn-glow-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #ffffff;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.55rem 1.2rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            transition: all 0.2s ease;
        }

        .btn-glow-primary:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Modal Dark Theme */
        .modal-content-dark {
            background-color: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc;
            border-radius: 16px;
        }

        .modal-header-dark {
            border-bottom: 1px solid #1e293b;
        }

        .modal-footer-dark {
            border-top: 1px solid #1e293b;
        }

        .form-control-dark {
            background-color: #020617 !important;
            border: 1px solid #334155 !important;
            color: #f8fafc !important;
            border-radius: 10px;
            padding: 0.65rem 1rem;
        }

        .form-control-dark:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title mb-0">Daftar Anggota</h3>
        <button type="button" class="btn btn-glow-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAnggota">
            + Tambah Anggota
        </button>
    </div>

    <!-- Pesan Error Validasi -->
    @if ($errors->any())
        <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25 text-danger-emphasis rounded-3 mb-3"
            role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-dark-custom shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark-custom table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Nama Anggota</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotas as $anggota)
                        <tr>
                            <td class="ps-4 fw-semibold text-white">{{ $anggota->nama }}</td>
                            <td>{{ $anggota->email }}</td>
                            <td>{{ $anggota->telepon ?? '-' }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('anggota.show', $anggota->id) }}" class="btn btn-sm btn-outline-info px-3"
                                    style="border-radius: 8px;">
                                    Lihat Profil
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-secondary">Belum ada data anggota.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-end">
        {{ $anggotas->links('pagination::bootstrap-5') }}
    </div>

    <!-- Modal Tambah Anggota -->
    <div class="modal fade" id="modalTambahAnggota" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-dark">
                <form action="{{ route('anggota.store') }}" method="POST">
                    @csrf
                    <div class="modal-header modal-header-dark p-3">
                        <h5 class="modal-title fw-bold text-white">Tambah Anggota Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Nama Lengkap <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control form-control-dark"
                                value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Email <span
                                    class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-dark"
                                value="{{ old('email') }}" placeholder="contoh@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">No. Telepon</label>
                            <input type="text" name="telepon" class="form-control form-control-dark"
                                value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-dark p-3">
                        <button type="button" class="btn btn-outline-secondary px-4" style="border-radius: 8px;"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-glow-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
