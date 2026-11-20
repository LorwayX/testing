<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievo — Buat Akun Baru</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #fceae1 0%, #fbd5e5 50%, #f8c0db 100%);
            --card-bg: rgba(255, 255, 255, 0.85);
            --card-border: rgba(255, 255, 255, 0.9);
            --primary-orange: linear-gradient(90deg, #ff9e2c 0%, #ff6f00 100%);
            --text-dark: #2d2626;
            --radius-xl: 28px;
        }

        body {
            background: var(--bg-gradient);
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .achievo-auth-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-xl);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 550px;
            padding: 40px;
        }

        .form-control {
            background-color: #fcfcfc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #ff9e2c;
            box-shadow: 0 0 0 4px rgba(255, 158, 44, 0.15);
        }

        .btn-primary-orange {
            background: var(--primary-orange);
            border: none;
            color: white;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            box-shadow: 0 4px 15px rgba(255, 111, 0, 0.3);
            transition: transform 0.2s;
        }

        .btn-primary-orange:hover {
            transform: translateY(-1px);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        {{ $slot }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>