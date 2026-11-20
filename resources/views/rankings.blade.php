<!-- filepath: c:\xampp\htdocs\Blokade 2\BackEnd\achievo\achievo\resources\views\rankings.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ranking Siswa — Achievo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            padding: 20px 15px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2b2323;
            background: linear-gradient(135deg, #fceae1 0%, #fbd5e5 50%, #f8c0db 100%);
            background-attachment: fixed;
        }
        .landing-container { max-width: 1000px; margin: 0 auto; }
        .glass-nav, .leaderboard-card {
            background: rgba(255, 255, 255, .82);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, .9);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .04);
        }
        .glass-nav { border-radius: 50px; padding: 12px 20px; }
        .leaderboard-card { border-radius: 28px; padding: 24px; }
        .rank-number {
            width: 34px; height: 34px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            color: white; font-weight: 700;
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }
        body.dark-mode {
            color: #e0fbfc;
            background: linear-gradient(135deg, #0b132b 0%, #1c2541 50%, #0b132b 100%);
        }
        body.dark-mode .glass-nav,
        body.dark-mode .leaderboard-card {
            background: rgba(28, 37, 65, .9);
            border-color: rgba(72, 202, 228, .2);
        }
        body.dark-mode .table { --bs-table-bg: transparent; --bs-table-color: #e0fbfc; }
        body.dark-mode .table-light { --bs-table-bg: rgba(255,255,255,.08); --bs-table-color: #90e0ef; }
        body.dark-mode .text-muted { color: #90e0ef !important; }
    </style>
</head>
<body id="app-body">
    <main class="landing-container">
        <nav class="glass-nav d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('welcome') }}" class="text-decoration-none text-reset fw-bold fs-5">
                <i class="bi bi-stars text-success me-2"></i>Achievo
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('welcome') }}" class="text-decoration-none text-reset">Beranda</a>
                <button type="button" onclick="toggleTheme()" class="btn btn-sm btn-light rounded-pill border">
                    <i id="theme-icon" class="bi bi-sun-fill text-warning"></i>
                </button>
            </div>
        </nav>

        <section class="leaderboard-card">
            <h3 class="fw-bold mb-1">Ranking Siswa</h3>
            <p class="text-muted small mb-4">Peringkat berdasarkan total poin prestasi terverifikasi.</p>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th class="py-3">PERINGKAT</th>
                            <th>NAMA SISWA</th>
                            <th>KELAS</th>
                            <th class="text-end">TOTAL POIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rankings ?? [] as $student)
                            <tr>
                                <td><span class="rank-number">{{ $loop->iteration }}</span></td>
                                <td class="fw-semibold">{{ $student->name }}</td>
                                <td>{{ $student->class_name ?? '-' }}</td>
                                <td class="text-end fw-bold text-warning">{{ $student->total_points ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada data ranking.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        function toggleTheme() {
            const body = document.getElementById('app-body');
            const icon = document.getElementById('theme-icon');
            body.classList.toggle('dark-mode');
            const dark = body.classList.contains('dark-mode');
            icon.className = dark ? 'bi bi-moon-stars-fill text-info' : 'bi bi-sun-fill text-warning';
            localStorage.setItem('achievo_theme', dark ? 'navy_mint' : 'light');
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