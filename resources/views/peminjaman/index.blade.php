@extends('layouts.app')

@section('content')
    <!-- Style khusus elemen halaman Peminjaman -->
    <style>
        .page-title {
            color: #ffffff !important;
            font-weight: 700;
            font-size: 1.6rem;
            letter-spacing: -0.5px;
        }

        /* Card Dark Custom */
        .card-dark-custom {
            background-color: #111827 !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        /* Table Dark Custom */
        .table-dark-custom {
            --bs-table-bg: transparent;
            --bs-table-color: #cbd5e1;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.03);
            color: #cbd5e1;
            margin-bottom: 0;
        }

        .table-dark-custom thead {
            background-color: #1f2937;
        }

        .table-dark-custom th {
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #374151 !important;
        }

        .table-dark-custom td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }

        /* Tombol Buat Peminjaman */
        .btn-glow-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            color: #ffffff;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.55rem 1.25rem;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
            transition: all 0.2s ease;
        }

        .btn-glow-primary:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Badges */
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
            display: inline-block;
        }

        /* Modal Dark */
        .modal-content-dark {
            background-color: #111827 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc;
            border-radius: 16px;
        }

        .modal-header-dark {
            border-bottom: 1px solid #1f2937;
        }

        .modal-footer-dark {
            border-top: 1px solid #1f2937;
        }

        .form-control-dark,
        .form-select-dark {
            background-color: #0b0f19 !important;
            border: 1px solid #374151 !important;
            color: #f8fafc !important;
            border-radius: 10px;
            padding: 0.65rem 1rem;
        }

        .form-control-dark:focus,
        .form-select-dark:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
        }

        .form-select-dark option {
            background-color: #111827;
            color: #f8fafc;
        }
    </style>

    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title mb-0">Data Peminjaman</h3>
        <button type="button" class="btn btn-glow-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPeminjaman">
            + Buat Peminjaman Baru
        </button>
    </div>

    <!-- Alert Errors -->
    @if ($errors->any())
        <div
            class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25 text-danger-emphasis rounded-3 mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card Tabel Data -->
    <div class="card card-dark-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark-custom table-hover align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Tanggal Pinjam</th>
                        <th>Anggota</th>
                        <th>Buku (Jumlah)</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $pinjam)
                        <tr>
                            <td class="ps-4 text-white font-monospace">{{ $pinjam->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="fw-semibold text-white">{{ $pinjam->anggota->nama }}</td>
                            <td>
                                <ul class="mb-0 ps-3">
                                    @foreach ($pinjam->detailPeminjamans as $detail)
                                        <li class="small">📖 {{ $detail->buku->judul }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                @if ($pinjam->status->value === 'dipinjam')
                                    <span class="badge badge-status-dipinjam">Dipinjam</span>
                                @else
                                    <span class="badge badge-status-kembali">
                                        Dikembalikan <br>
                                        <small
                                            style="font-size: 0.7rem; opacity: 0.85;">({{ $pinjam->tanggal_kembali->format('d M Y') }})</small>
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if ($pinjam->status->value === 'dipinjam')
                                    <form action="{{ route('peminjaman.kembalikan', $pinjam->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah buku ini sudah dikembalikan?');" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success px-3"
                                            style="border-radius: 8px;">
                                            Proses Kembalikan
                                        </button>
                                    </form>
                                @else
                                    <span class="text-secondary small fw-medium">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">Belum ada transaksi peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-end">
        {{ $peminjamans->links('pagination::bootstrap-5') }}
    </div>

    <!-- Modal Tambah Peminjaman -->
    <div class="modal fade" id="modalTambahPeminjaman" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-dark">
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="modal-header modal-header-dark p-3">
                        <h5 class="modal-title fw-bold text-white">Transaksi Peminjaman</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Pilih Anggota <span
                                    class="text-danger">*</span></label>
                            <select name="anggota_id" class="form-select form-select-dark" required>
                                <option value="">-- Pilih Anggota --</option>
                                @foreach ($anggotas as $anggota)
                                    <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Pilih Buku <span
                                    class="text-danger">*</span></label>
                            <select name="buku_ids[]" class="form-select form-select-dark" multiple required
                                style="height: 130px;">
                                @foreach ($bukus as $buku)
                                    <option value="{{ $buku->id }}">{{ $buku->judul }} (Sisa: {{ $buku->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-secondary mt-1 d-block" style="font-size: 0.78rem;">
                                💡 Tahan tombol <kbd class="bg-dark text-light border border-secondary px-1">CTRL</kbd> /
                                <kbd class="bg-dark text-light border border-secondary px-1">CMD</kbd> untuk memilih lebih
                                dari satu buku.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-medium">Tanggal Pinjam <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pinjam" class="form-control form-control-dark"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-dark p-3">
                        <button type="button" class="btn btn-outline-secondary px-4" style="border-radius: 8px;"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-glow-primary px-4">Proses Peminjaman</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
