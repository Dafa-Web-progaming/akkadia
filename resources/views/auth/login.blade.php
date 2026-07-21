<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas Perpustakaan</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Font - Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #020617;
            min-height: 100vh;
            color: #f8fafc;
            overflow-x: hidden;
            position: relative;
        }

        /* Canvas background untuk Efek Gravitasi */
        #gravity-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .container-wrapper {
            position: relative;
            z-index: 10;
        }

        .card-login {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7),
                0 0 30px rgba(37, 99, 235, 0.15);
        }

        .brand-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
            animation: pulse-glow 3s infinite alternate;
        }

        @keyframes pulse-glow {
            0% {
                box-shadow: 0 0 15px rgba(37, 99, 235, 0.3);
            }

            100% {
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.6);
            }
        }

        .form-label {
            color: #94a3b8;
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            z-index: 10;
            transition: color 0.2s ease;
        }

        .form-control-dark {
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #f8fafc;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control-dark:focus {
            background-color: #0f172a;
            border-color: #3b82f6;
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
        }

        .form-control-dark:focus+.input-icon,
        .input-group-custom:focus-within .input-icon {
            color: #3b82f6;
        }

        .btn-custom-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #ffffff;
            padding: 0.8rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-custom-primary:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5);
            color: #ffffff;
        }

        .btn-custom-primary:active {
            transform: translateY(0);
        }

        .alert-custom {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
            border-radius: 12px;
            font-size: 0.875rem;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <!-- Canvas Simulasi Gravitasi -->
    <canvas id="gravity-canvas"></canvas>

    <div class="container container-wrapper py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

                <div class="card card-login p-3 p-sm-4">
                    <div class="card-body">

                        <!-- Header / Logo -->
                        <div class="text-center mb-4">
                            <div class="brand-icon mb-3">
                                <i class="bi bi-book-half fs-3 text-white"></i>
                            </div>
                            <h4 class="fw-bold mb-1 text-white">Login Petugas</h4>
                            <p class="text-secondary small">Sistem Manajemen Perpustakaan</p>
                        </div>

                        <!-- Alert Errors -->
                        @if ($errors->any())
                            <div class="alert alert-custom d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                                <div>{{ $errors->first() }}</div>
                            </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group-custom">
                                    <input type="email" name="email" class="form-control form-control-dark"
                                        value="{{ old('email') }}" placeholder="nama@email.com" required>
                                    <i class="bi bi-envelope input-icon"></i>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <div class="input-group-custom">
                                    <input type="password" name="password" class="form-control form-control-dark"
                                        placeholder="••••••••" required>
                                    <i class="bi bi-lock input-icon"></i>
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-custom-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                <span>Masuk ke Akun</span>
                                <i class="bi bi-arrow-right-short fs-5"></i>
                            </button>
                        </form>

                    </div>
                </div>

                <!-- Footer Text -->
                <p class="text-center text-secondary small mt-4">
                    &copy; {{ date('Y') }} Sistem Perpustakaan. All rights reserved.
                </p>

            </div>
        </div>
    </div>

    <!-- Script Fisika Gravitasi Partikel -->
    <script>
        const canvas = document.getElementById('gravity-canvas');
        const ctx = canvas.getContext('2d');

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        const particles = [];
        const particleCount = 50;
        const gravity = 0.06; // Kekuatan gravitasi

        class GravityParticle {
            constructor() {
                this.reset(true);
            }

            reset(initial = false) {
                this.x = Math.random() * canvas.width;
                this.y = initial ? Math.random() * canvas.height : -15;
                this.radius = Math.random() * 3 + 1.5;
                this.vx = (Math.random() - 0.5) * 1.2;
                this.vy = Math.random() * 1 + 0.5;
                this.bounce = Math.random() * 0.3 + 0.3; // Daya pantul
                this.alpha = Math.random() * 0.6 + 0.2;
                this.color = Math.random() > 0.3 ? '#3b82f6' : '#60a5fa';
            }

            update() {
                this.vy += gravity; // Aplikasi gravitasi
                this.x += this.vx;
                this.y += this.vy;

                // Pantulan di batas bawah layar
                if (this.y + this.radius > canvas.height) {
                    this.y = canvas.height - this.radius;
                    this.vy = -this.vy * this.bounce;

                    // Reset partikel jika energinya sudah habis
                    if (Math.abs(this.vy) < 0.6) {
                        this.reset();
                    }
                }

                // Wrap-around horizontal
                if (this.x < 0) this.x = canvas.width;
                if (this.x > canvas.width) this.x = 0;
            }

            draw() {
                ctx.save();
                ctx.globalAlpha = this.alpha;
                ctx.shadowBlur = 12;
                ctx.shadowColor = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = this.color;
                ctx.fill();
                ctx.restore();
            }
        }

        // Inisialisasi Partikel
        for (let i = 0; i < particleCount; i++) {
            particles.push(new GravityParticle());
        }

        // Loop Animasi
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(animate);
        }

        animate();
    </script>
</body>

</html>
