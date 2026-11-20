<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak — Achievo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Playfair+Display:wght@800&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #fba867 0%, #fbd1d9 50%, #f79cc3 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; padding: 20px; }
        .error-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-radius: 36px; padding: 50px 40px; text-center; max-width: 460px; border: 1px solid rgba(255,255,255,0.9); }
    </style>
</head>
<body>
    <div class="error-card text-center">
        <div class="bg-warning text-white rounded-4 mx-auto mb-4 d-flex align-items-center justify-content-center shadow-sm" style="width:70px; height:70px; background: linear-gradient(135deg, #fbbf24, #d97706) !important; font-size: 2rem;">🔒</div>
        <h2 class="fw-bold mb-2" style="font-family:'Playfair Display', serif; font-size:2rem;">Akses ditolak</h2>
        <p class="text-muted small mb-4">Halaman ini bersifat privat atau hanya untuk warga sekolah. Silahkan masuk untuk melanjutkan.</p>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('welcome') }}" class="btn btn-light rounded-pill px-4 py-2 fw-semibold border">Beranda</a>
            <a href="{{ route('login') }}" class="btn btn-warning text-white rounded-pill px-4 py-2 fw-semibold" style="background: linear-gradient(90deg, #f59e0b, #d97706); border:none;">Masuk</a>
        </div>
    </div>
</body>
</html>