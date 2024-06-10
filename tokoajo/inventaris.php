<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Toko Ajo Lpn</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php"><b>Toko Ajo Lpn</b></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-power-off"></i> | Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                                Transaksi
                            </a>
                            <a class="nav-link" href="inventaris.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-box-open"></i></div>
                                <b>Inventaris</b>
                            </a>
                            <a class="nav-link" href="laporan.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-line"></i></div>
                                Laporan
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <?php
                        $username = $_SESSION['username'];
                        ?>
                        <div class="small">Login Sebagai:</div>
                        <?=$username;?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Inventaris</h1>
                        <br>
                        <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#myModal">
                            <i class="fa-solid fa-square-plus"></i>
                             Tambahkan Produk
                            </button>
                            <a href="cetakdataproduk.php" class="btn btn-secondary" target="_blank">
                            <i class="fa-solid fa-print"></i>
                             Cetak Data Produk</a>
                            <br><br>

                        <!-- Alert Duplikasi Produk -->
                        <?php if (!empty($_SESSION['duplikasiproduk'])): ?>
                            <script>
                            // Menutup alert duplikasi secara otomatis setelah 5 detik
                            window.setTimeout(function() {
                                document.getElementById('duplikasialert').style.display = 'none';
                            }, <?=$_SESSION['detikalertduplikasi']?> * 1000);
                        </script>
                            <div id="duplikasialert" class="alert alert-warning alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <strong>Perhatian!</strong> <?= $_SESSION['duplikasiproduk']; ?>
                            </div>
                            <?php
                                // Kosongkan variabel $duplikasiproduk
                                unset($_SESSION['duplikasiproduk']);
                            ?>
                        <?php endif; ?>

                            <?php
                                $ambildatastok = mysqli_query($koneksi,"SELECT * FROM produk WHERE stok < 1");

                                while($fetch=mysqli_fetch_array($ambildatastok)){
                                    $produk = $fetch['namaproduk'];
                                
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <strong>Perhatian!</strong> Stok dari <b>"<?=$produk;?>"</b> telah habis.
                            </div>

                            <?php
                                }
                            ?>
                            
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Daftar Produk                               
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $ambilsemuadataproduk = mysqli_query($koneksi,"SELECT * FROM produk");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadataproduk)){
                                            $namaproduk = $data['namaproduk'];
                                            $harga = $data['harga'];
                                            $stok = $data['stok'];
                                            $idproduk = $data['idproduk'];
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namaproduk;?></td>
                                            <td><?=$harga;?></td>
                                            <td><?=$stok;?></td>
                                            <td>
                                            <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#edit<?=$idproduk;?>">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?=$idproduk;?>">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                            </td>
                                        </tr> 
                                        
                                            <!-- Edit Produk Modal -->
                                            <div class="modal fade" id="edit<?=$idproduk;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Edit Produk</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    Nama Produk
                                                    <input type="text" name="namaproduk" value="<?=$namaproduk;?>" class="form-control" required>
                                                    
                                                    Harga
                                                    <input type="number" name="harga" value="<?=$harga;?>" class="form-control" required>
                                                    
                                                    Stok
                                                    <input type="number" name="stok" value="<?=$stok;?>" class="form-control" required>
                                                    <input type="hidden" name="idproduk" value="<?=$idproduk;?>">
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-warning" name="updateproduk">Update</button>
                                                        </div>
                                                    </div>
                                                    </form>

                                                </div>
                                                </div>
                                            </div>

                                            <!-- Hapus Produk Modal -->
                                            <div class="modal fade" id="hapus<?=$idproduk;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Produk?</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus produk <b>"<?=$namaproduk;?>"</b>?
                                                    <input type="hidden" name="idproduk" value="<?=$idproduk;?>">
                                                    <br><br>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger" name="hapusproduk">Hapus</button>
                                                        </div>
                                                    </div>
                                                    </form>

                                                </div>
                                                </div>
                                            </div>

                                        <?php
                                        };
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2024</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

    <!-- Tambahkan Produk Modal -->
    <div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Tambahkan Produk</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
         <form method="post">
            <div class="modal-body">
            <input type="text" name="namaproduk" placeholder="Nama Produk" class="form-control" required>
            <br>
            <input type="number" name="harga" placeholder="Harga" class="form-control" required>
            <br>
            <input type="number" name="stok" placeholder="Stok" class="form-control" required>
            <br>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="tambahprodukbaru">Tambahkan</button>
                </div>
            </div>
        </form>

        </div>
    </div>
    </div>
    
</html>
