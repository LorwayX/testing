<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievo — Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #fceae1 0%, #fbd5e5 50%, #f8c0db 100%);
            --card-bg: rgba(255, 255, 255, 0.85);
            --text-color: #2d2626;
            --sidebar-bg: rgba(255, 245, 238, 0.95);
        }
        body { background: var(--bg-gradient); background-attachment: fixed; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-color); min-height: 100vh; padding: 20px; }
        .achievo-card { background: var(--card-bg); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.6); border-radius: 28px; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04); }
        .sidebar { background: var(--sidebar-bg); backdrop-filter: blur(12px); border-radius: 28px; padding: 24px; min-height: calc(100vh - 40px); display: flex; flex-direction: column; justify-content: space-between; }
        .nav-link-achievo { display: flex; align-items: center; padding: 10px 18px; border-radius: 50px; color: #666; font-weight: 500; text-decoration: none; margin-bottom: 6px; transition: 0.2s; font-size: 0.9rem; }
        .nav-link-achievo:hover, .nav-link-achievo.active { background: linear-gradient(90deg, #ff9e2c 0%, #ff6f00 100%); color: #fff !important; font-weight: 600; box-shadow: 0 4px 15px rgba(255, 111, 0, 0.3); }
        .btn-orange { background: linear-gradient(90deg, #ff9e2c 0%, #ff6f00 100%); border: none; color: white; border-radius: 50px; font-weight: 600; }
    </style>
</head>
<body>
    @php
        $currentAuth = auth()->user();
        $adminDisplayName = $currentAuth ? $currentAuth->name : 'Admin Sekolah';
        $adminInitials = substr($adminDisplayName, 0, 2);
    @endphp
    <div class="container-fluid">
        <div class="row g-4">
            <!-- Sidebar Admin -->
            <div class="col-lg-3 col-xl-2">
                <div class="sidebar shadow-sm">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-3 px-2">
                            <div class="bg-warning text-white rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm" style="width:36px; height:36px;"><i class="bi bi-stars"></i></div>
                            <h4 class="fw-bold mb-0">Achievo</h4>
                        </div>
                        <small class="text-muted px-2 d-block mb-2 fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">PANEL ADMIN</small>
                        <nav class="nav flex-column">
                            <a class="nav-link-achievo {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid me-2"></i> Dashboard</a>
                            <a class="nav-link-achievo {{ request()->routeIs('admin.verifications') ? 'active' : '' }}" href="{{ route('admin.verifications') }}"><i class="bi bi-check2-circle me-2"></i> Verifikasi</a>
                            <a class="nav-link-achievo {{ request()->routeIs('admin.categories') ? 'active' : '' }}" href="{{ route('admin.categories') }}"><i class="bi bi-folder me-2"></i> Kategori</a>
                            <a class="nav-link-achievo {{ request()->routeIs('admin.points') ? 'active' : '' }}" href="{{ route('admin.points') }}"><i class="bi bi-award me-2"></i> Aturan Poin</a>
                            <a class="nav-link-achievo {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}"><i class="bi bi-gear me-2"></i> Pengaturan</a>
                            <a class="nav-link-achievo {{ request()->routeIs('admin.logs') ? 'active' : '' }}" href="{{ route('admin.logs') }}"><i class="bi bi-clock-history me-2"></i> Log Aktivitas</a>
                        </nav>
                    </div>
                    <div>
                        <a href="{{ route('switch.role', 'student') }}" class="text-decoration-none text-muted small d-block mb-3 px-2 fw-semibold">Lihat Sebagai Siswa <i class="bi bi-arrow-right"></i></a>
                        <div class="bg-white rounded-pill p-2 d-flex align-items-center justify-content-between shadow-sm border">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:34px; height:34px; font-size: 0.75rem;">{{ $adminInitials }}</div>
                                <div>
                                    <div class="fw-bold lh-1 mb-1 text-dark" style="font-size: 0.75rem;">{{ $adminDisplayName }}</div>
                                    <div class="text-muted lh-1" style="font-size: 0.65rem;">Administrator</div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit" class="btn btn-sm btn-light rounded-circle border-0 text-danger" title="Keluar"><i class="bi bi-box-arrow-right"></i></button></form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Konten Utama -->
            <div class="col-lg-9 col-xl-10">
                <div class="achievo-card p-4 p-md-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
