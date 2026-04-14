<!DOCTYPE html>

<html>

<head>

    <title>Login Admin - SMKN 1 Buntok</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body {

            min-height: 100vh;

            background-image: url('/asetsekolah/SMKN1BUNTOK.jpg');

            background-size: cover;

            background-position: center;

            background-attachment: fixed;

            display: flex;

            align-items: center;

            justify-content: center;

        }

        body::before {

            content: '';

            position: fixed;

            inset: 0;

            background: rgba(40, 10, 90, 0.72);

            z-index: 0;

        }

        .login-wrapper {

            position: relative;

            z-index: 1;

            width: 100%;

            max-width: 420px;

            padding: 1rem;

        }

        .login-card {

            background: rgba(255,255,255,0.95);

            border-radius: 20px;

            padding: 2.5rem 2rem;

            box-shadow: 0 20px 60px rgba(0,0,0,0.3);

        }

        .logo-circle {

            width: 72px;

            height: 72px;

            background: linear-gradient(135deg, #7C3AED, #A855F7);

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 32px;

            margin: 0 auto 1rem;

        }

        .login-title {

            text-align: center;

            font-weight: 700;

            font-size: 22px;

            color: #3B0764;

            margin-bottom: 4px;

        }

        .login-subtitle {

            text-align: center;

            font-size: 13px;

            color: #6B7280;

            margin-bottom: 1.8rem;

        }

        .form-label {

            font-size: 13px;

            font-weight: 500;

            color: #374151;

        }

        .form-control {

            border-radius: 10px;

            border: 1.5px solid #E5E7EB;

            padding: 10px 14px;

            font-size: 14px;

        }

        .form-control:focus {

            border-color: #A855F7;

            box-shadow: 0 0 0 3px rgba(168,85,247,0.15);

        }

        .btn-login {

            width: 100%;

            padding: 11px;

            border-radius: 10px;

            background: linear-gradient(135deg, #7C3AED, #A855F7);

            border: none;

            color: white;

            font-weight: 600;

            font-size: 15px;

            margin-top: 0.5rem;

            transition: opacity 0.2s;

        }

        .btn-login:hover { opacity: 0.9; color: white; }

        .divider {

            text-align: center;

            font-size: 12px;

            color: #9CA3AF;

            margin: 1.2rem 0 0;

        }

        .back-link {

            display: block;

            text-align: center;

            font-size: 13px;

            color: #7C3AED;

            text-decoration: none;

            margin-top: 8px;

        }

        .back-link:hover { text-decoration: underline; color: #6D28D9; }

    </style>

</head>

<body>


<div class="login-wrapper">

    <div class="login-card">


        <div class="text-center mb-3">

        <img src="/asetsekolah/LOGOSMKN1BUNTOK.png" style="height:80px;">

        </div>


        <div class="login-subtitle">Masuk sebagai Admin Pengaduan Sekolah</div>


        @if(session('error'))

            <div class="alert alert-danger py-2" style="font-size:13px; border-radius:10px;">

                {{ session('error') }}

            </div>

        @endif


        <form action="/admin/login" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">Username</label>

                <input type="text" name="username" class="form-control"

                       placeholder="Masukkan username" required autofocus>

            </div>

            <div class="mb-3">

                <label class="form-label">Password</label>

                <input type="password" name="password" class="form-control"

                       placeholder="Masukkan password" required>

            </div>

            <button type="submit" class="btn-login">Masuk</button>

        </form>


        <div class="divider">— atau —</div>

        <a href="/" class="back-link">← Kembali ke halaman siswa</a>


    </div>

</div>


</body>

</html>