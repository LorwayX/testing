<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Login - Achievo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #fceae1 0%, #fbd5e5 50%, #f8c0db 100%); font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .auth-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); border-radius: 28px; padding: 40px; width: 100%; max-width: 480px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
        .btn-orange { background: linear-gradient(90deg, #ff9e2c 0%, #ff6f00 100%); border: none; color: white; border-radius: 50px; padding: 12px; font-weight: 600; width: 100%; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="d-flex align-items-center gap-2 mb-4">
            <div class="bg-warning text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:38px; height:38px;"><i class="bi bi-stars"></i></div>
            <h4 class="fw-bold mb-0">Achievo</h4>
        </div>
        <h3 class="fw-bold mb-1">Selamat datang kembali</h3>
        <p class="text-muted small mb-4">Masuk untuk melanjutkan ke Achievo</p>
        
        @if ($errors->any())
            <div class="alert alert-danger py-2 small rounded-4 mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small text-muted fw-semibold">Email, NIS, atau Username</label>
                <input type="text" name="email" class="form-control rounded-3 p-3" value="{{ old('email', 'alicia@gmail.com') }}" placeholder="alicia@gmail.com / 1234561" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label small text-muted fw-semibold">Kata Sandi</label>
                <input type="password" name="password" class="form-control rounded-3 p-3" value="password" placeholder="Masukkan kata sandi" required>
            </div>
            <button type="submit" class="btn btn-orange mb-3 shadow-sm">Masuk</button>
            <div class="text-center">
                <span class="text-muted small">Belum punya akun? </span><a href="{{ route('register') }}" class="text-decoration-none fw-semibold small" style="color:#ff6f00;">Daftar di sini</a>
            </div>
        </form>
    </div>
</body>
</html>
