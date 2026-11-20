<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru — Achievo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #fba867 0%, #fbd1d9 50%, #f79cc3 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif; padding: 20px; }
        .auth-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-radius: 36px; padding: 40px; border: 1px solid rgba(255,255,255,0.9); width: 100%; max-width: 540px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        .form-control { border-radius: 50px; padding: 12px 20px; border: 1px solid #eee; background: #fff; }
        .btn-orange { background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); color: white; border: none; border-radius: 50px; font-weight: 700; padding: 14px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="d-flex align-items-center gap-2 mb-4">
            <div class="bg-warning text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:36px; height:36px; background: linear-gradient(135deg, #fbbf24, #f59e0b) !important;">✨</div>
            <h4 class="fw-bold mb-0" style="font-family:'Playfair Display', serif;">Achievo</h4>
        </div>
        <h2 class="fw-extrabold mb-1" style="font-family:'Playfair Display', serif; font-weight:800;">Buat akun baru</h2>
        <p class="text-muted small mb-4">Bergabung dan mulai catat prestasimu</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small rounded-4 mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label small fw-semibold text-secondary">NIS</label>
                    <input type="text" name="student_number" class="form-control" placeholder="1234567" value="{{ old('student_number') }}" required>
                </div>
                <div class="col-6">
                    <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Tuliskan nama lengkap" value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Email</label>
                <input type="email" name="email" class="form-control" placeholder="alicia@gmail.com" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Kata sandi</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Konfirmasi kata sandi</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="terms" required checked>
                <label class="form-check-label small text-muted" for="terms">Saya setuju dengan syarat dan ketentuan yang berlaku</label>
            </div>
            <button type="submit" class="btn btn-orange w-100 shadow-sm mb-3">Daftar</button>
            <div class="text-center">
                <span class="text-muted small">Sudah punya akun? </span><a href="{{ route('login') }}" class="text-decoration-none fw-semibold small" style="color:#d97706;">Masuk di sini</a>
            </div>
        </form>
    </div>
</body>
</html>
