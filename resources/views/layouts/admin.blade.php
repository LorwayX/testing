<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin — Achievo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #fceae1 0%, #fbd5e5 50%, #f8c0db 100%);
            --card-bg: rgba(255, 255, 255, 0.85);
            --text-color: #2d2626;
            --sidebar-bg: rgba(255, 245, 238, 0.95);
        }

        body.dark-mode {
            --bg-gradient: linear-gradient(135deg, #0b132b 0%, #1c2541 50%, #0b132b 100%);
            --card-bg: rgba(28, 37, 65, 0.85);
            --text-color: #e0fbfc;
            --sidebar-bg: rgba(11, 19, 43, 0.95);
        }

        body.dark-mode .bg-white,
        body.dark-mode .card,
        body.dark-mode .sidebar,
        body.dark-mode .achievo-card {
            background-color: #1c2541 !important;
            color: #e0fbfc !important;
            border-color: rgba(72, 202, 228, 0.2) !important;
        }

        body.dark-mode .table {
            color: #e0fbfc;
        }

        body.dark-mode .table-light {
            background-color: #0b132b !important;
            color: #52b788 !important;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #0b132b;
            color: #52b788;
            border-color: rgba(82, 183, 136, 0.3);
        }

        body.dark-mode .text-muted {
            color: #90e0ef !important;
        }

        body {
            background: var(--bg-gradient);
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-color);
            min-height: 100vh;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .achievo-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 28px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
        }

        .sidebar {
            background: var(--sidebar-bg);
            backdrop-filter: blur(12px);
            border-radius: 28px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .nav-link-achievo {
            display: flex;
            align-items: center;
            padding: 10px 18px;
            border-radius: 50px;
            color: #666;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 6px;
            transition: 0.2s;
            font-size: 0.9rem;
        }

        body.dark-mode .nav-link-achievo {
            color: #90e0ef;
        }

        .nav-link-achievo:hover,
        .nav-link-achievo.active {
            background: linear-gradient(90deg, #52b788 0%, #2a9d8f 100%);
            color: #fff !important;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(42, 157, 143, 0.4);
        }

        @media (max-width: 991.98px) {
            .sidebar {
                min-height: auto;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body id="app-body">
    @php
        $currentAdmin = auth()->user();
        $adminDisplayName = $currentAdmin ? $currentAdmin->name : 'Admin Sekolah';
        $adminInitials = substr($adminDisplayName, 0, 2);
    @endphp
    <div class="container-fluid px-0 px-md-3">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-2">
                <div class="sidebar shadow-sm">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-3 px-2">
                            <div class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm"
                                style="width:36px; height:36px;"><i class="bi bi-shield-lock-fill"></i></div>
                            <h4 class="fw-bold mb-0">Admin Panel</h4>
                        </div>
                        <small class="text-muted px-2 d-block mb-2 fw-bold"
                            style="font-size: 0.65rem; letter-spacing: 0.5px;">NAVIGASI ADMIN</small>
                        <nav class="nav flex-column">
                            <a class="nav-link-achievo {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}"><i class="bi bi-grid me-2"></i> Dashboard
                                Admin</a>
                            <a class="nav-link-achievo {{ request()->routeIs('admin.verifications') ? 'active' : '' }}"
                                href="{{ route('admin.verifications') }}"><i class="bi bi-check2-circle me-2"></i>
                                Verifikasi Prestasi</a>
                            <a class="nav-link-achievo {{ request()->routeIs('admin.categories') ? 'active' : '' }}"
                                href="{{ route('admin.categories') }}"><i class="bi bi-tags me-2"></i> Kategori</a>
                            <a class="nav-link-achievo {{ request()->routeIs('admin.points') ? 'active' : '' }}"
                                href="{{ route('admin.points') }}"><i class="bi bi-award me-2"></i> Aturan Poin</a>
                            <a class="nav-link-achievo {{ request()->routeIs('admin.settings') ? 'active' : '' }}"
                                href="{{ route('admin.settings') }}"><i class="bi bi-gear me-2"></i> Pengaturan</a>
                            <a class="nav-link-achievo {{ request()->routeIs('admin.logs') ? 'active' : '' }}"
                                href="{{ route('admin.logs') }}"><i class="bi bi-clock-history me-2"></i> Log
                                Aktivitas</a>
                        </nav>
                    </div>
                    <div>
                        <a href="{{ url('/dashboard') }}"
                            class="text-decoration-none text-muted small d-block mb-3 px-2 fw-semibold">
                            Lihat Dashboard Siswa <i class="bi bi-arrow-right"></i>
                        </a>
                        <div
                            class="bg-white rounded-pill p-2 d-flex align-items-center justify-content-between shadow-sm border">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width:34px; height:34px; font-size: 0.75rem;">{{ $adminInitials }}</div>
                                <div>
                                    <div class="fw-bold lh-1 mb-1" style="font-size: 0.75rem;">{{ $adminDisplayName }}
                                    </div>
                                    <div class="text-muted lh-1" style="font-size: 0.65rem;">Administrator</div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit"
                                    class="btn btn-sm btn-light rounded-circle border-0 text-danger" title="Keluar"><i
                                        class="bi bi-box-arrow-right"></i></button></form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-xl-10">
                <div class="achievo-card p-3 p-md-4">
                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" onclick="toggleTheme()"
                            class="btn btn-sm btn-light rounded-pill px-3 shadow-sm border d-flex align-items-center gap-2">
                            <i id="theme-icon" class="bi bi-sun-fill text-warning"></i>
                            <span id="theme-text">Mode Terang</span>
                        </button>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @yield('modals')
    <script>
        function toggleTheme() {
            const body = document.getElementById('app-body');
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            body.classList.toggle('dark-mode');
            if (body.classList.contains('dark-mode')) {
                themeIcon.className = 'bi bi-moon-stars-fill text-info';
                themeText.innerText = 'Mode Deep Navy';
                localStorage.setItem('achievo_theme', 'navy_mint');
            } else {
                themeIcon.className = 'bi bi-sun-fill text-warning';
                themeText.innerText = 'Mode Terang';
                localStorage.setItem('achievo_theme', 'light');
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('achievo_theme') === 'navy_mint') {
                document.getElementById('app-body').classList.add('dark-mode');
                document.getElementById('theme-icon').className = 'bi bi-moon-stars-fill text-info';
                document.getElementById('theme-text').innerText = 'Mode Deep Navy';
            }
        });
    </script>
</body>

</html>