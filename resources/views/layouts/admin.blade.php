<!DOCTYPE html>


<html>


<head>


    <title>Dashboard Admin - SMKN 1 BUNTOK</title>


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


            background: rgba(40, 10, 90, 0.72);


            z-index: 0;


        }


        .navbar {


            position: relative;


            z-index: 10;


            background: rgba(255,255,255,0.10) !important;


            backdrop-filter: blur(12px);


            border-bottom: 1px solid rgba(255,255,255,0.15);


        }


        .navbar-brand {


            color: white !important;


            font-weight: 700;


        }


        .navbar .btn { color: white; border-color: rgba(255,255,255,0.3); }


        .navbar .btn:hover { background: rgba(255,255,255,0.15); color: white; }


        .main-wrapper {


            position: relative;


            z-index: 1;


            padding: 2rem 0 3rem;


        }


        .card {


            border: none !important;


            border-radius: 16px !important;


            box-shadow: 0 8px 32px rgba(0,0,0,0.2) !important;


        }


        .btn-primary {


            background: linear-gradient(135deg, #7C3AED, #A855F7) !important;


            border: none !important;


        }


        .btn-success {


            background: linear-gradient(135deg, #059669, #10B981) !important;


            border: none !important;


        }


        h3, h5, h6 { color: white !important; }


        .table { background: white; border-radius: 12px; overflow: hidden; }


        .form-control:focus, .form-select:focus {


            border-color: #A855F7;


            box-shadow: 0 0 0 3px rgba(168,85,247,0.15);


        }


    </style>


</head>


<body>



<nav class="navbar navbar-expand-lg">


    <div class="container">


        <a class="navbar-brand d-flex align-items-center gap-2" href="/admin/dashboard">

        <img src="{{ asset('asetsekolah/LOGOSMKN1BUNTOK.png') }}" style="height:24px;">

        SMKN 1 BUNTOK

        </a>


        <div class="d-flex gap-2 flex-wrap">
                    
            <a href="/admin/dashboard" class="btn btn-sm">Dashboard</a>


            <a href="/admin/kategori" class="btn btn-sm">Kategori</a>


            <a href="/admin/siswa" class="btn btn-sm">Data Siswa</a>


            <a href="/admin/saran" class="btn btn-sm">Data Saran</a>


            <a href="/logout" class="btn btn-sm" style="background:rgba(220,38,38,0.5);">Logout</a>


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