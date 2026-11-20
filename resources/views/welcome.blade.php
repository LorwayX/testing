<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievo — Setiap Prestasi Layak Bersinar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #fceae1 0%, #fbd5e5 50%, #f8c0db 100%);
            --glass-nav: rgba(255, 255, 255, 0.85);
            --card-bg: rgba(255, 255, 255, 0.8);
            --orange-gradient: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
        }

        body.dark-mode {
            --bg-gradient: linear-gradient(135deg, #0b132b 0%, #1c2541 50%, #0b132b 100%);
            --glass-nav: rgba(28, 37, 65, 0.85);
            --card-bg: rgba(28, 37, 65, 0.85);
            --orange-gradient: linear-gradient(90deg, #52b788 0%, #2a9d8f 100%);
        }

        body.dark-mode .card-glass,
        body.dark-mode .leaderboard-card,
        body.dark-mode .glass-nav {
            background: rgba(28, 37, 65, 0.9) !important;
            color: #e0fbfc !important;
            border-color: rgba(72, 202, 228, 0.2) !important;
        }

        body.dark-mode .hero-title {
            color: #e0fbfc !important;
        }

        body.dark-mode .hero-title span {
            color: #52b788 !important;
        }

        body.dark-mode .text-secondary {
            color: #90e0ef !important;
        }

        body.dark-mode .nav-links a {
            color: #90e0ef !important;
        }

        body {
            background: var(--bg-gradient);
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2b2323;
            min-height: 100vh;
            padding: 20px 15px;
            transition: all 0.3s ease;
        }

        .landing-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .glass-nav {
            background: var(--glass-nav);
            backdrop-filter: blur(16px);
            border-radius: 50px;
            padding: 12px 20px;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        }

        .nav-links a {
            color: #555;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .btn-gold {
            background: var(--orange-gradient);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            padding: 10px 24px;
            box-shadow: 0 6px 20px rgba(42, 157, 143, 0.3);
        }

        .btn-outline-soft {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.9);
            color: #333;
            border-radius: 50px;
            font-weight: 600;
            padding: 10px 24px;
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            gap: 6px;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 3.8rem);
            font-weight: 800;
            line-height: 1.1;
            color: #1a1515;
        }

        .hero-title span {
            color: #d97706;
        }

        .card-glass {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.85);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
        }

        .leaderboard-card {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.9);
        }

        .rank-avatar {
            width: 32px;
            height: 32px;
            background: var(--orange-gradient);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .certificate-image {
            width: 100%;
            height: 220px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.55);
            border-radius: 18px;
        }

        body.dark-mode .certificate-image {
            background: rgba(255, 255, 255, 0.08);
        }
    </style>
</head>

<body id="app-body">
    <div class="landing-container">
        <div class="glass-nav d-flex justify-content-between align-items-center mb-4 mb-md-5">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm text-white"
                    style="width:36px; height:36px; background: #52b788;">
                    <i class="bi bi-stars"></i>
                </div>
                <h4 class="fw-bold mb-0" style="font-family:'Playfair Display', serif; font-size: 1.3rem;">
                    Achievo
                </h4>
            </div>

            <div class="nav-links d-none d-md-flex gap-4">
                <a href="#fitur">Fitur</a>
                <a href="{{ route('rankings') }}">Ranking</a>
                <a href="{{ route('profile.public', 'ashley') }}">Profil Siswa</a>
            </div>

            <div class="d-flex align-items-center gap-2 gap-md-3">
                <button type="button" onclick="toggleTheme()"
                    class="btn btn-sm btn-light rounded-pill px-2 py-1 border shadow-sm d-flex align-items-center gap-1">
                    <i id="theme-icon" class="bi bi-sun-fill text-warning"></i>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-gold text-nowrap py-2 px-3 fs-6">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-gold text-nowrap py-2 px-3 fs-6">Masuk</a>
                @endauth
            </div>
        </div>

        <div class="row align-items-start pt-2">
            <div class="col-lg-7 pe-lg-4 mb-5 mb-lg-0">
                <div class="hero-badge mb-3">
                    <span class="text-warning">🏆</span> Portofolio Prestasi Siswa
                </div>

                <h1 class="hero-title mb-3">
                    Setiap Prestasi <br><span>Layak Bersinar.</span>
                </h1>

                <p class="text-secondary fs-6 mb-4 lh-lg">
                    Catat pencapaianmu, dapatkan verifikasi dari sekolah, dan lihat posisimu di papan peringkat -
                    semuanya di satu tempat.
                </p>

                <div class="d-flex flex-column flex-sm-row gap-3 mb-5">
                    <a href="{{ route('register') }}" class="btn btn-gold py-3 px-4 text-center shadow-sm">
                        Mulai Sekarang <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <a href="{{ route('rankings') }}" class="btn btn-outline-soft py-3 px-4 text-center">
                        Lihat Ranking
                    </a>
                </div>

                <div class="row g-3">
                    <div class="col-4">
                        <div class="card-glass p-3 text-center">
                            <h3 class="fw-extrabold mb-0 fs-4">230+</h3>
                            <small class="text-muted fw-semibold" style="font-size: 0.7rem;">Siswa aktif</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card-glass p-3 text-center">
                            <h3 class="fw-extrabold mb-0 fs-4">1.250+</h3>
                            <small class="text-muted fw-semibold" style="font-size: 0.7rem;">Terverifikasi</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card-glass p-3 text-center">
                            <h3 class="fw-extrabold mb-0 fs-4">15+</h3>
                            <small class="text-muted fw-semibold" style="font-size: 0.7rem;">Kategori</small>
                        </div>
                    </div>
                </div>

                <section class="mt-4 mb-5" id="fitur">
                    <h4 class="fw-bold mb-1">Bukti Prestasi Siswa</h4>
                    <p class="text-secondary small mb-3">
                        Sertifikat dari prestasi yang telah diverifikasi.
                    </p>

                    <div class="row g-3">
                        @forelse($featuredCertificates ?? [] as $certificate)
                            <div class="col-12 col-md-4">
                                <div class="card-glass p-3 h-100">
                                    <img class="certificate-image mb-3"
                                        src="{{ asset('storage/' . $certificate->evidence_path) }}"
                                        alt="Sertifikat: {{ $certificate->title }}">
                                    <h6 class="fw-bold mb-1">{{ $certificate->title }}</h6>
                                    <small class="text-secondary">
                                        {{ $certificate->user->name ?? 'Siswa' }}
                                    </small>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card-glass p-4 text-center text-secondary">
                                    Belum ada sertifikat yang ditampilkan.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <div class="col-lg-5">
                <div class="leaderboard-card mb-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0" style="font-family:'Playfair Display', serif;">
                            Papan Peringkat
                        </h6>
                        <small class="text-muted fw-semibold" style="font-size: 0.75rem;">2026/2027</small>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        @foreach(($topRanks ?? []) as $i => $row)
                            <div
                                class="bg-white p-2 px-3 rounded-4 d-flex justify-content-between align-items-center shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="fw-bold text-dark small">{{ $i + 1 }}</span>
                                    <div class="rank-avatar">{{ substr($row->name, 0, 2) }}</div>
                                    <span class="fw-bold text-dark small">{{ $row->name }}</span>
                                </div>
                                <span class="fw-bold text-dark small">
                                    {{ $row->achievements_sum_points ?? 0 }} pts
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleTheme() {
            const body = document.getElementById('app-body');
            const themeIcon = document.getElementById('theme-icon');

            body.classList.toggle('dark-mode');

            if (body.classList.contains('dark-mode')) {
                themeIcon.className = 'bi bi-moon-stars-fill text-info';
                localStorage.setItem('achievo_theme', 'navy_mint');
            } else {
                themeIcon.className = 'bi bi-sun-fill text-warning';
                localStorage.setItem('achievo_theme', 'light');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('achievo_theme') === 'navy_mint') {
                document.getElementById('app-body').classList.add('dark-mode');
                document.getElementById('theme-icon').className = 'bi bi-moon-stars-fill text-info';
            }
        });
    </script>
</body>

</html>