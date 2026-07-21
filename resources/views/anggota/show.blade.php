@extends('layouts.app')

@section('content')
    <!-- Custom Styles: Tema Dark Navy & Fix Layout -->
    <style>
        /* 1. Body background gelap & netralkan wrapper agar tidak molor */
        html,
        body {
            background-color: #020617 !important;
            color: #f8fafc !important;
            min-height: 100vh;
        }

        #app,
        main,
        .content,
        .container,
        .container-fluid {
            background-color: transparent !important;
            min-height: auto !important;
        }

        /* 2. Style Kartu Utama */
        .card-dark-custom {
            background-color: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .card-header-dark {
            background-color: #1e293b !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            padding: 1rem 1.25rem;
        }

        .card-header-dark h5 {
            color: #f8fafc;
            font-weight: 600;
        }

        /* 3. Style Tabel Dark */
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

        /* 4. List Group Dark (Rekomendasi Buku) */
        .list-group-dark .list-group-item {
            background-color: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
            padding: 1rem 1.25rem;
            transition: background-color 0.2s ease;
        }

        .list-group-dark .list-group-item:hover {
            background-color: rgba(30, 41, 59, 0.5);
        }

        /* 5. Badge Status Peminjaman & Kategori */
        .badge-status-dipinjam {
            background-color: rgba(245, 158, 11, 0.15) !important;
            color: #fbbf24 !important;
            border: 1px solid rgba(245, 158, 11, 0.3);
            padding: 0.4em 0.75em;
            border-radius: 8px;
            font-weight: 500;
        }

        .badge-status-kembali {
            background-color: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 0.4em 0.75em;
            border-radius: 8px;
            font-weight: 500;
        }

        .badge-kategori {
            background-color: rgba(59, 130, 246, 0.15) !important;
            color: #60a5fa !important;
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 6px;
            font-size: 0.75rem;
        }

        /* 6. Tombol Kembali Custom */
        .btn-back-custom {
            background-color: #1e293b;
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .btn-back-custom:hover {
            background-color: #334155;
            color: #ffffff;
        }

        /* Image Thumbnail Dark */
        .img-cover-thumb {
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: #020617;
            border-radius: 6px;
        }
    </style>

    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="{{ route('anggota.index') }}" class="btn btn-back-custom btn-sm px-3 py-2">
            &larr; Kembali ke Daftar Anggota
        </a>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri: Profil & Rekomendasi Buku -->
        <div class="col-md-4">
            <!-- Card Profil Anggota -->
            <div class="card card-dark-custom mb-4">
                <div class="card-header card-header-dark">
                    <h5 class="card-title mb-0">👤 Profil Anggota</h5>
                </div>
                <div class="card-body p-4">
                    <h3 class="h5 mb-1 text-white fw-bold">{{ $anggota->nama }}</h3>
                    <p class="text-secondary small mb-3">ID Anggota: #{{ $anggota->id }}</p>
                    <hr style="border-color: rgba(255, 255, 255, 0.1);">
                    <div class="mb-3">
                        <small class="text-secondary d-block">Email</small>
                        <strong class="text-white">{{ $anggota->email }}</strong>
                    </div>
                    <div class="mb-0">
                        <small class="text-secondary d-block">No. Telepon</small>
                        <strong class="text-white">{{ $anggota->telepon ?? '-' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Req #6: Card Rekomendasi Buku -->
            <div class="card card-dark-custom">
                <div class="card-header card-header-dark d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0 fs-6">💡 Rekomendasi Buku Untuk Anda</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush list-group-dark">
                        @forelse($rekomendasiBuku as $rekomendasi)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="me-2">
                                        <h6 class="mb-1 fw-bold text-white">{{ $rekomendasi->judul }}</h6>
                                        <small class="text-secondary d-block">Penulis: {{ $rekomendasi->penulis }}</small>
                                        <span
                                            class="badge badge-kategori mt-2">{{ $rekomendasi->kategori->nama ?? 'Umum' }}</span>
                                    </div>
                                    @if ($rekomendasi->cover_path)
                                        <img src="{{ Storage::url($rekomendasi->cover_path) }}" alt="Cover"
                                            width="45" class="img-cover-thumb flex-shrink-0">
                                    @endif
                                </div>
                                <div class="mt-2 d-flex justify-content-between align-items-center">
                                    <small style="color: #34d399;" class="fw-medium">Stok: {{ $rekomendasi->stok }}
                                        tersedia</small>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-secondary small">
                                Belum ada rekomendasi spesifik. Tambah riwayat peminjaman terlebih dahulu.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Req #9 Riwayat Peminjaman Buku -->
        <div class="col-md-8">
            <div class="card card-dark-custom">
                <div class="card-header card-header-dark">
                    <h5 class="card-title mb-0 fs-6">📜 Riwayat Transaksi Peminjaman</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">ID Pinjam</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Buku yang Dipinjam</th>
                                    <th class="text-end pe-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anggota->peminjamans as $pinjam)
                                    <tr>
                                        <td class="ps-4"><strong class="text-white">#{{ $pinjam->id }}</strong></td>
                                        <td>{{ $pinjam->tanggal_pinjam->format('d M Y') }}</td>
                                        <td>
                                            <ul class="list-unstyled mb-0 ps-0">
                                                @foreach ($pinjam->detailPeminjamans as $detail)
                                                    <li class="text-slate-300 small mb-1">
                                                        📖 {{ $detail->buku->judul ?? '[Buku Dihapus]' }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="text-end pe-4">
                                            @if ($pinjam->status->value === 'dipinjam')
                                                <span class="badge badge-status-dipinjam">Dipinjam</span>
                                            @else
                                                <span class="badge badge-status-kembali d-inline-block text-end">
                                                    Dikembalikan <br>
                                                    <small
                                                        style="font-size: 0.7rem; opacity: 0.85;">({{ $pinjam->tanggal_kembali?->format('d M Y') }})</small>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-secondary">
                                            Anggota ini belum pernah melakukan transaksi peminjaman buku.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
