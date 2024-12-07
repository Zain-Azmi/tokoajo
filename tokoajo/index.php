<?php
require 'function.php';
require 'cek.php';

// Dummy data untuk dashboard
// Mendapatkan tanggal hari ini
$tanggalHariIni = date('Y-m-d');

// Query untuk mendapatkan total transaksi hari ini
$queryJumlahTransaksiHariIni = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah_transaksi FROM transaksi WHERE tanggaltransaksi = '$tanggalHariIni'");
$dataTransaksiHariIni = mysqli_fetch_assoc($queryJumlahTransaksiHariIni);
$jumlahTransaksiHariIni = $dataTransaksiHariIni['jumlah_transaksi'] ?? 0; // Jika NULL, set ke 0

// Query untuk mendapatkan total pendapatan hari ini
$queryPendapatanHariIni = mysqli_query($koneksi, "SELECT SUM(jumlahtransaksi) AS total_pendapatan FROM transaksi WHERE tanggaltransaksi = '$tanggalHariIni'");
$pendapatanHariIni = mysqli_fetch_assoc($queryPendapatanHariIni);
$totalPendapatanHariIni = $pendapatanHariIni['total_pendapatan'] ?? 0; // Jika NULL, set ke 0

$queryTotalProduk = mysqli_query($koneksi, "SELECT COUNT(*) AS total_produk FROM produk");
$dataTotalProduk = mysqli_fetch_assoc($queryTotalProduk);
$totalProduk = $dataTotalProduk['total_produk'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Home - Toko Ajo Lpn</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex: 1;
        }

        .dashboard-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .hero-section {
            position: relative;
            color: white;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            padding: 250px 20px;
            min-height: 300px;
            overflow: hidden;
        }

        .hero-section img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(60%);
            z-index: -1; /* Memastikan gambar tidak menghalangi teks */
        }

        .hero-section h2, .hero-section p {
            position: relative;
            z-index: 1; /* Memastikan teks berada di atas gambar */
        }

        .nav-item {
            display: inline-block;
            margin-left: 10px;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
        }

 
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Header -->
        <header class="d-flex justify-content-between align-items-center bg-dark text-white p-3 rounded">
            <h1 class="h4">Toko Ajo Lpn</h1>
            <nav>
                <a href="transaksi.php" class="text-white mx-2 text-decoration-none">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                    Transaksi</a>
                <a href="inventaris.php" class="text-white mx-2 text-decoration-none">
                <i class="fa-solid fa-box-open"></i>
                    Inventaris</a>
                <a href="laporan.php" class="text-white mx-2 text-decoration-none">
                <i class="fa-solid fa-chart-line"></i>
                    Laporan</a>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-power-off"></i> | Logout</a></li>
                </ul>
            </li>
            </nav>
        </header>

        <!-- Informasi tentang Toko -->
        <section class="hero-section mt-4">
            <img src="assets/img/supermarket-aisle.jpg" alt="Supermarket" class="img-fluid">
            <h2 class="h3">Selamat Datang di Toko Ajo Lpn!</h2>
            <p>
                Toko Ajo Lpn adalah toko ritel yang menyediakan berbagai macam kebutuhan harian, mulai dari 
                produk makanan, minuman, hingga kebutuhan rumah tangga lainnya. Kami berkomitmen memberikan layanan terbaik 
                dan pengalaman belanja yang nyaman kepada pelanggan kami.
            </p>
        </section>

        <!-- Ringkasan Dashboard -->
        <section class="mt-4 row">
            <div class="col-md-4">
                <div class="card bg-primary text-white dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Transaksi Hari Ini</h5>
                        <p class="card-text fs-4"><?= $jumlahTransaksiHariIni; ?> Transaksi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Produk</h5>
                        <p class="card-text fs-4"><?= $totalProduk; ?> Produk</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Pendapatan Hari Ini</h5>
                        <p class="card-text fs-4">Rp <?= number_format($totalPendapatanHariIni, 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
        <!-- Footer -->
        <footer class="py-4 bg-light mt-auto">         
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Toko Ajo Lpn 2024</div>
                    <div>
                    </div>
                </div>
            </div>
        </footer>
    
    <!-- Tambahkan script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>