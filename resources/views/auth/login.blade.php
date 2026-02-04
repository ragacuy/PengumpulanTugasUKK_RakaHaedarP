<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Peminjaman Alat</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        .login-container {
            min-height: 100vh;
        }

        .left-side {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .left-side::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -50%;
            left: -50%;
            z-index: 0;
            pointer-events: none;
        }

        .left-side-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .brand-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .right-side {
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 2px solid #eef0f3;
            background-color: #f8f9fa;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4e54c8;
            box-shadow: 0 0 0 4px rgba(78, 84, 200, 0.1);
            background-color: white;
        }

        .input-group-text {
            border: 2px solid #eef0f3;
            border-left: none;
            background-color: #f8f9fa;
            border-radius: 0 0.5rem 0.5rem 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .form-control:focus + .input-group-text {
            border-color: #4e54c8;
            background-color: white;
        }

        .btn-primary {
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 84, 200, 0.3);
            background: linear-gradient(to right, #454bb9, #7c81f0);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .form-label {
            font-weight: 500;
            color: #555;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .welcome-text {
            margin-bottom: 2rem;
        }
        
        .welcome-text h2 {
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            color: #777;
        }

        /* Mobile adjustments */
        @media (max-width: 767.98px) {
            .left-side {
                min-height: 200px;
                padding: 2rem;
            }
            .brand-icon {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0 login-container">
        <!-- Left Side (Brand/Welcome) -->
        <div class="col-md-6 col-lg-7 left-side d-none d-md-flex">
            <div class="left-side-content">
                <i class="bi bi-box-seam brand-icon"></i>
                <h1 class="display-4 fw-bold mb-3">Peminjaman Alat</h1>
                <p class="lead mb-0 text-white-50">Sistem manajemen inventaris yang modern dan efisien.</p>
            </div>
        </div>

        <!-- Right Side (Form) -->
        <div class="col-md-6 col-lg-5 right-side">
            <div class="login-card fade-in">
                <!-- Mobile Logo (Visible only on small screens) -->
                <div class="text-center d-md-none mb-4">
                    <h3 class="fw-bold text-primary">
                        <i class="bi bi-box-seam me-2"></i>Peminjaman Alat
                    </h3>
                </div>

                <div class="welcome-text">
                    <h2>Selamat Datang! 👋</h2>
                    <p>Silakan login untuk mengakses akun Anda.</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted border-end-0" style="border-radius: 0.5rem 0 0 0.5rem; border-right: none;">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" class="form-control border-start-0 ps-0" placeholder="nama@email.com" required style="border-radius: 0 0.5rem 0.5rem 0;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted border-end-0" style="border-radius: 0.5rem 0 0 0.5rem; border-right: none;">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" class="form-control border-start-0 border-end-0 ps-0" placeholder="Masukkan password" required style="border-radius: 0;">
                            <span class="input-group-text" onclick="togglePasswordVisibility()">
                                <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label text-muted small" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                        <a href="#" class="text-primary text-decoration-none small fw-medium">Lupa Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2.5 shadow-sm">
                        Masuk Sekarang <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                    
                    <div class="mt-4 text-center">
                        <p class="text-muted small">Belum punya akun? <a href="#" class="text-primary fw-medium text-decoration-none">Hubungi Admin</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>

</body>
</html>
