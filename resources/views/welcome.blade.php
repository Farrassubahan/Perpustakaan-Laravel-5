<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>L Farpus | Sistem Perpustakaan</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fafc, #eef2f7);
            color: #1f2937;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            width: 100%;
            padding: 20px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #1d4ed8;
        }

        .logo span {
            color: #0f172a;
        }

        .nav-links a {
            margin-left: 15px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s ease;
        }

        .btn-login {
            color: #1d4ed8;
            border: 1px solid #1d4ed8;
            background: white;
        }

        .btn-login:hover {
            background: #1d4ed8;
            color: white;
        }

        .btn-register {
            background: #1d4ed8;
            color: white;
            border: 1px solid #1d4ed8;
        }

        .btn-register:hover {
            background: #1e40af;
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 120px 60px 60px;
            gap: 40px;
        }

        .hero-text {
            flex: 1;
        }

        .hero-text h1 {
            font-size: 54px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            color: #0f172a;
        }

        .hero-text h1 span {
            color: #1d4ed8;
        }

        .hero-text p {
            font-size: 18px;
            color: #4b5563;
            line-height: 1.8;
            max-width: 600px;
            margin-bottom: 30px;
        }

        .hero-buttons a {
            display: inline-block;
            margin-right: 15px;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 500;
            transition: 0.3s ease;
        }

        .btn-primary {
            background: #1d4ed8;
            color: white;
        }

        .btn-primary:hover {
            background: #1e40af;
        }

        .btn-secondary {
            background: white;
            color: #1d4ed8;
            border: 1px solid #cbd5e1;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .card-illustration {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .book-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            border-radius: 16px;
            background: #f8fafc;
            margin-bottom: 15px;
            border: 1px solid #e2e8f0;
        }

        .book-row:last-child {
            margin-bottom: 0;
        }

        .book-info h4 {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 5px;
        }

        .book-info p {
            font-size: 13px;
            color: #64748b;
        }

        .status {
            font-size: 12px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 999px;
        }

        .available {
            background: #dcfce7;
            color: #166534;
        }

        .borrowed {
            background: #fee2e2;
            color: #991b1b;
        }

        .features {
            padding: 80px 60px;
            background: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 36px;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .section-title p {
            color: #64748b;
            font-size: 16px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
        }

        .feature-card {
            background: #f8fafc;
            padding: 30px 25px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            transition: 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.06);
        }

        .feature-card h3 {
            font-size: 20px;
            margin-bottom: 12px;
            color: #1d4ed8;
        }

        .feature-card p {
            font-size: 14px;
            color: #475569;
            line-height: 1.7;
        }

        .footer {
            text-align: center;
            padding: 25px;
            font-size: 14px;
            color: #64748b;
            background: #f8fafc;
        }

        @media (max-width: 992px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }

            .hero-text p {
                margin: 0 auto 30px;
            }

            .navbar {
                padding: 20px 25px;
            }

            .hero,
            .features {
                padding-left: 25px;
                padding-right: 25px;
            }

            .hero-text h1 {
                font-size: 40px;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .hero-text h1 {
                font-size: 32px;
            }

            .hero-buttons a {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="logo">Far<span>pus</span></div>

        @if (Route::has('login'))
            <div class="nav-links">
                @if (Auth::check())
                    <a href="{{ route('user.home') }}" class="btn-register">Dashboard</a>
                @else
                    <a href="{{ url('/login') }}" class="btn-login">Login</a>
                    <a href="{{ url('/register') }}" class="btn-register">Register</a>
                @endif
            </div>
        @endif
    </div>

    <section class="hero">
        <div class="hero-text">
            <h1>Selamat Datang di <span>L Farpus</span></h1>
            <p>
                Sistem perpustakaan digital yang membantu pengguna mencari buku, meminjam,
                mengelola koleksi, dan memantau aktivitas perpustakaan dengan lebih mudah,
                cepat, dan modern.
            </p>

            <div class="hero-buttons">
                @if (Auth::check())
                    <a href="{{ route('user.home') }}" class="btn-primary">Masuk ke Dashboard</a>
                @else
                    <a href="{{ url('/login') }}" class="btn-primary">Mulai Sekarang</a>
                    <a href="#fitur" class="btn-secondary">Lihat Fitur</a>
                @endif
            </div>
        </div>

        <div class="hero-image">
            <div class="card-illustration">
                @forelse($books as $book)
                    <div class="book-row">
                        <div class="book-info">
                            <h4>{{ $book->title }}</h4>
                            <p>{{ $book->author }}</p>
                        </div>
                        <span class="status {{ $book->stock > 0 ? 'available' : 'borrowed' }}">
                            {{ $book->stock > 0 ? 'Tersedia' : 'Dipinjam' }}
                        </span>
                    </div>
                @empty
                    <div class="book-row">
                        <div class="book-info">
                            <h4>Belum Ada Koleksi</h4>
                            <p>-</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="features" id="fitur">
        <div class="section-title">
            <h2>Fitur Unggulan L Farpus</h2>
            <p>Dirancang untuk memudahkan pengelolaan perpustakaan modern.</p>
        </div>

        <div class="feature-grid">
            <div class="feature-card">
                <h3><i class="fa fa-book"></i> Manajemen Buku</h3>
                <p>Kelola data buku, kategori, stok, dan informasi koleksi secara terstruktur.</p>
            </div>

            <div class="feature-card">
                <h3><i class="fa fa-users"></i> Data Anggota</h3>
                <p>Catat dan kelola data anggota perpustakaan dengan sistem yang rapi and efisien.</p>
            </div>

            <div class="feature-card">
                <h3><i class="fa fa-exchange"></i> Peminjaman</h3>
                <p>Proses peminjaman dan pengembalian buku menjadi lebih cepat dan mudah dipantau.</p>
            </div>

            <div class="feature-card">
                <h3><i class="fa fa-bar-chart"></i> Laporan</h3>
                <p>Lihat statistik dan laporan aktivitas perpustakaan untuk kebutuhan administrasi.</p>
            </div>
        </div>
    </section>

    <div class="footer">
        &copy; {{ date('Y') }} L Farpus - Sistem Informasi Perpustakaan
    </div>

</body>

</html>
