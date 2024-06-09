<?php
require 'function.php';
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
                <div class="input-group">
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
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
                        <div class="small">Login Sebagai:</div>
                        Admin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Transaksi</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                    Tambah Produk
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Sub-Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $get = mysqli_query($koneksi,"SELECT * FROM detail_transaksi WHERE idtransaksii = (SELECT idtransaksii FROM idtransaksi ORDER BY nomor DESC LIMIT 1);");
                                       $jumlahtransaksikasir=0;
                                       $tulisanjumlahtransaksikasir="Rp 0";
                                       while ($p=mysqli_fetch_array($get)){
                                        $idproduk=$p['idproduk'];
                                        $namaproduk=$p['namaproduk'];
                                        $harga=$p['harga'];
                                        $jumlah=$p['jumlah'];
                                        $subtotal=$harga*$jumlah;
                                        $jumlahtransaksikasir+=$subtotal;
                                        $numjumlahtransaksikasir=number_format($jumlahtransaksikasir);
                                        $tulisanjumlahtransaksikasir="Rp " . (string)$numjumlahtransaksikasir;
                                    
                                       ?>
                                            <tr>
                                                <td><?=$idproduk;?></td>
                                                <td><?=$namaproduk;?></td>
                                                <td>Rp <?=number_format($harga);?></td>
                                                <td><?=number_format($jumlah);?></td>
                                                <td>Rp <?=number_format($subtotal);?></td>
                                                <td>
                                            <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#edit<?=$idproduk;?>">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?=$idproduk;?>">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                            </td>
                                            </tr> 
                                             <!-- Hapus Detail Transaksi Modal -->
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
                                                            <button type="submit" class="btn btn-danger" name="hapusprodukdetailtransaksi">Hapus</button>
                                                        </div>
                                                    </div>
                                                    </form>

                                                </div>
                                                </div>
                                            </div>
                                         <!-- Edit Detail Transaksi Modal -->
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
                                                    <input type="text" name="namaproduk" value="<?=$namaproduk;?>" class="form-control" disabled>
                                                    
                                                    Jumlah
                                                    <input type="number" name="jumlah" value="<?=$jumlah;?>" class="form-control" required>

                                                    <input type="hidden" name="idproduk" value="<?=$idproduk;?>">
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-warning" name="updateprodukdetailtransaksi">Update</button>
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
                                <form method="post">
                                <h4>Jumlah Pembayaran</h4>
                                <input type="hidden" name="idtransaksii" value="<?=$idtransaksii;?>">
                                <input type="hidden" name="jumlahtransaksi" value="<?=$jumlahtransaksikasir;?>"disabled>
                                <input type="text" name="tulisanjumlahtransaksi" value="<?=$tulisanjumlahtransaksikasir;?>"disabled>
                                <br>
                                <br>
                                <button type="submit" class="btn btn-primary" name="tambahlaporantransaksi">Selesai Transaksi</button>
                                
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                            </div>
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

                                       

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Tambah Produk</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <form method="post">
    <div class="modal-body">
        Pilih Barang
        <select name="idproduk" id="produkSelect" class="form-control" required>
        <?php
        $getproduk = mysqli_query($koneksi, "SELECT * FROM produk where idproduk not in (select idproduk from detail_transaksi where idtransaksii = (SELECT idtransaksii FROM idtransaksi ORDER BY nomor DESC LIMIT 1) );");
        while ($pr = mysqli_fetch_array($getproduk)){
            $idproduk = $pr['idproduk'];
            $namaproduk = $pr['namaproduk'];
            $harga = $pr['harga'];
        ?>
            <option value="<?=$idproduk;?>" data-namaproduk="<?=$namaproduk;?>" data-harga="<?=$harga;?>"><?=$namaproduk;?> - <?=$harga;?></option>
        <?php
        }
        ?>
        </select>
        <br>
        <input type="hidden" name="idtransaksii" id="idtransaksii" required>
        <input type="hidden" name="namaproduk" id="namaproduk" required>
        <input type="hidden" name="harga" id="harga" required>
        <input type="number" name="jumlah" placeholder="Jumlah" class="form-control" required>
        <br>
        <button type="submit" class="btn btn-primary" name="tambahprodukkasir">Tambahkan</button>
    </div>
</form>

<script>
    document.getElementById('produkSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var namaproduk = selectedOption.getAttribute('data-namaproduk');
        var harga = selectedOption.getAttribute('data-harga');

        document.getElementById('namaproduk').value = namaproduk;
        document.getElementById('harga').value = harga;
    });

    // Trigger change event to set initial values
    document.getElementById('produkSelect').dispatchEvent(new Event('change'));
</script>


        <!-- Modal footer -->
        <div class="modal-footer">
        <form method="post">
        </form>    
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
    </div>
</html>