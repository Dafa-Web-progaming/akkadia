<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Tema Dark Navy -->
    <style>
        /* 1. Background Utama Dark Navy */
        html,
        body {
            background-color: #0b0f19 !important;
            color: #f8fafc !important;
            min-height: 100vh;
        }

        /* 2. Styling Navbar Dark Navy */
        .navbar-custom {
            background-color: #111827 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .navbar-custom .navbar-brand {
            color: #ffffff !important;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .navbar-custom .nav-link {
            color: #94a3b8 !important;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #ffffff !important;
        }

        /* 3. Tombol Logout Custom */
        .btn-logout-custom {
            color: #f8fafc;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background-color: rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
            border-radius: 8px;
        }

        .btn-logout-custom:hover {
            background-color: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.4);
            color: #fca5a5;
        }

        /* 4. Alert Dark Theme */
        .alert-success-dark {
            background-color: rgba(16, 185, 129, 0.15) !important;
            border: 1px solid rgba(16, 185, 129, 0.3) !important;
            color: #34d399 !important;
        }

        .alert-danger-dark {
            background-color: rgba(239, 68, 68, 0.15) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #fca5a5 !important;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('buku.index') }}">Akkadia</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('buku.index') }}">Buku</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('anggota.index') }}">Anggota</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('peminjaman.index') }}">Peminjaman</a></li>
                </ul>
                <form method="POST" action="{{ route('logout') }}" class="d-flex">
                    @csrf
                    <button type="submit" class="btn btn-logout-custom btn-sm">Logout
                        ({{ auth()->user()->name }})</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        {{-- Tempat untuk Flash Messages (Success/Error) --}}
        @if (session('success'))
            <div class="alert alert-success-dark rounded-3 mb-3 p-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger-dark rounded-3 mb-3 p-3">{{ session('error') }}</div>
        @endif

        {{-- Tempat Konten Utama --}}
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
