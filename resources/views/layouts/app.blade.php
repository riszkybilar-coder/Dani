<!DOCTYPE html>


<html>


<head>


    <title>Pengaduan Sekolah - SMKN 1 BUNTOK</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>


        body {


            min-height: 100vh;


            background-image: url('/asetsekolah/SMKN1BUNTOK.jpg');


            background-size: cover;


            background-position: center;


            background-attachment: fixed;


        }


        body::before {


            content: '';


            position: fixed;


            inset: 0;


            background: rgba(60, 20, 120, 0.65);


            z-index: 0;


        }


        .navbar {


            position: relative;


            z-index: 10;


            background: rgba(255,255,255,0.12) !important;


            backdrop-filter: blur(10px);


            border-bottom: 1px solid rgba(255,255,255,0.2);


        }


        .logo-sekolah{

        height:22px;

        width:auto;

        margin-right:8px;

        }


        .navbar-brand {


            color: white !important;


            font-weight: 700;


            font-size: 18px;


        }


        .navbar .btn {


            border-color: rgba(255,255,255,0.4);


            color: white;


        }


        .navbar .btn:hover {


            background: rgba(255,255,255,0.2);


            color: white;


        }


        .main-wrapper {


            position: relative;


            z-index: 1;


            padding: 2rem 0 3rem;


        }


        .card, .card-pengaduan {


            border: none !important;


            border-radius: 16px !important;


            box-shadow: 0 8px 32px rgba(0,0,0,0.18) !important;


        }


        .card-header {


            border-radius: 16px 16px 0 0 !important;


            background: linear-gradient(135deg, #7C3AED, #A855F7) !important;


            border: none !important;


        }


        .btn-primary {


            background: linear-gradient(135deg, #7C3AED, #A855F7) !important;


            border: none !important;


        }


        .btn-primary:hover {


            background: linear-gradient(135deg, #6D28D9, #9333EA) !important;


        }


        .form-control:focus, .form-select:focus {


            border-color: #A855F7;


            box-shadow: 0 0 0 3px rgba(168,85,247,0.15);


        }


        .page-title {


            color: white;


            font-weight: 700;


            text-shadow: 0 2px 8px rgba(0,0,0,0.3);


            margin-bottom: 1.5rem;


        }


    </style>


</head>


<body>



<nav class="navbar navbar-expand-lg">

        <div class="container">


        <a class="navbar-brand d-flex align-items-center" href="/">

        <img src="/asetsekolah/LOGOSMKN1BUNTOK.png" style="height:30px; width:auto; margin-right:8px;">

        SMKN 1 BUNTOK

        </a>


        <div class="d-flex gap-2 flex-wrap">


            <a href="/" class="btn btn-sm">Rumah</a>


            <a href="/form" class="btn btn-sm">Buat Pengaduan</a>


            <a href="{{ route('saran.form') }}" class="btn btn-sm">Kirim Saran</a>


            <a href="{{ route('cek.form') }}" class="btn btn-sm">Cek Status</a>


            <a href="/admin" class="btn btn-sm" style="background:rgba(255,255,255,0.2);">Login Admin</a>


        </div>


    </div>


</nav>



<div class="main-wrapper">


    <div class="container">


        @yield('content')


    </div>


</div>



</body>


</html>