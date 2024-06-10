
<?php
session_start();

//Konek ke Database
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "retail";
$koneksi = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
//Buat Ambil ID Transaksi
$query = "SELECT * FROM idtransaksi ORDER BY nomor DESC LIMIT 1";
$hasilidtransaksii = mysqli_query($koneksi, $query);
$pidtransaksii=mysqli_fetch_array($hasilidtransaksii);
$idtransaksii=$pidtransaksii['idtransaksii'];

//Buat bikin total pembelian
$totalsubtotal = mysqli_query($koneksi,"SELECT SUM(sub_total) as total_subtotal FROM detail_transaksi WHERE idtransaksii = (SELECT idtransaksii FROM detail_transaksi ORDER BY idtransaksii DESC LIMIT 1);");  
$totalsub=mysqli_fetch_array($totalsubtotal);
$subtotaltotal=$totalsub['total_subtotal'];
$jumlahtransaksi=$subtotaltotal;

// Tambah Barang ke Inventaris
if(isset($_POST['tambahprodukbaru'])){
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

// Pengecekan apakah nama produk sudah ada
$cekproduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE namaproduk='$namaproduk'");
$hitung = mysqli_num_rows($cekproduk);

if($hitung < 1){
    // Jika tidak ada duplikasi produk
    $addtotable = mysqli_query($koneksi,"INSERT INTO produk (namaproduk, harga, stok) VALUES('$namaproduk','$harga','$stok')");
    if ($addtotable){
        header('location:inventaris.php');
    } else {
        echo "<script type='text/javascript'>
                alert('Gagal Menambahkan Produk!');
                window.location.href = 'inventaris.php';
             </script>";
    }
} else {
    // Jika ada duplikasi produk
    $row = mysqli_fetch_assoc($cekproduk);
    $namaprodukduplikasi = $row['namaproduk'];
    $_SESSION['detikalertduplikasi'] = 6;
    $_SESSION['duplikasiproduk'] = "Produk dengan nama <b>\"$namaprodukduplikasi\"</b> sudah ada. Pesan ini akan ditutup dalam <b>".$_SESSION['detikalertduplikasi']."</b> detik.";
    }
}
// Update Info Barang
if(isset($_POST['updateproduk'])){
    $idproduk = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $update = mysqli_query($koneksi,"UPDATE produk SET namaproduk='$namaproduk', harga='$harga', stok='$stok' WHERE idproduk='$idproduk'");
    if ($update){
        header('location:inventaris.php');
    } else {
        echo "<script type='text/javascript'>
                alert('Gagal Meng-Update Produk!');
                window.location.href = 'inventaris.php';
             </script>";
    }
}

// Menghapus Barang dengan Stok
if(isset($_POST['hapusproduk'])){
    $idproduk = $_POST['idproduk'];

    $hapus = mysqli_query($koneksi,"DELETE FROM produk WHERE idproduk='$idproduk'");
    if ($hapus){
        header('location:inventaris.php');
    } else {
        echo "<script type='text/javascript'>
                alert('Gagal Menghapus Produk!');
                window.location.href = 'inventaris.php';
             </script>";
    }
}

// Masukin Data Ke Tabel Detail Transaksi
if(isset($_POST['tambahprodukkasir'])){
    $idproduk = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $subtotal =$harga*$jumlah;

    $stokcek = mysqli_query($koneksi,"SELECT stok FROM produk WHERE idproduk='$idproduk'");
    $stok = mysqli_fetch_array($stokcek);
        $jumlahstok = $stok['stok'];

    if ($jumlah > $jumlahstok) {
        $_SESSION['stokkurang'] = "Stok tidak mencukupi untuk produk <b>\"$namaproduk\"</b>! Sisa stok: <b>$jumlahstok</b>";
    } else {
        $addtotable = mysqli_query($koneksi,"insert into detail_transaksi (idtransaksii,idproduk,namaproduk, harga, jumlah,sub_total) values('$idtransaksii','$idproduk','$namaproduk','$harga','$jumlah',$subtotal)");
        if ($addtotable){
            header('location:index.php');
        } else {
            echo 'Gagal Menambahkan Barang ke Transaksi';
        }
    }    

}

// Masukin Data Ke Tabel Transaksi
if(isset($_POST['tambahlaporantransaksi'])){
    $idtransaksii = $_POST['idtransaksii'];
    $jumlahtransaksi = $_POST['jumlahtransaksi'];

    // Ambil Semua Produk di Transaksi (id)
    $getproduk = mysqli_query($koneksi, "SELECT namaproduk, jumlah FROM detail_transaksi WHERE idtransaksii='$idtransaksii'");
    $stokcukup = true;

    // Cek Stok dari Produk Tadi
    while($p = mysqli_fetch_array($getproduk)){
        $namaproduk = $p['namaproduk'];
        $jumlah = $p['jumlah'];
        
        $cekstok = mysqli_query($koneksi, "SELECT stok FROM produk WHERE namaproduk='$namaproduk'");
        $data = mysqli_fetch_array($cekstok);
        $stok = $data['stok'];

        if($stok < $jumlah){
            $stokcukup = false;
            break;
        }
    }

    if($stokcukup){
        // Kurangi Stok dari Tiap Produk
        mysqli_data_seek($getproduk, 0); // Reset Query

        while($p = mysqli_fetch_array($getproduk)){
            $namaproduk = $p['namaproduk'];
            $jumlah = $p['jumlah'];

            $cekstok = mysqli_query($koneksi, "SELECT stok FROM produk WHERE namaproduk='$namaproduk'");
            $data = mysqli_fetch_array($cekstok);
            $stok = $data['stok'];
            $stokbaru = $stok - $jumlah;

            $updatestok = mysqli_query($koneksi, "UPDATE produk SET stok='$stokbaru' WHERE namaproduk='$namaproduk'");
        }

        // Tambahkan transaksi ke tabel transaksi
        $addtotable = mysqli_query($koneksi, "INSERT INTO transaksi (idtransaksii, jumlahtransaksi) VALUES ('$idtransaksii', '$jumlahtransaksi')");
        
        if($addtotable){
            // Tambahkan idtransaksii ke tabel idtransaksi
            $angkaidtransaksii = $idtransaksii + 1;
            $addtotableidtransaksii = mysqli_query($koneksi, "INSERT INTO idtransaksi (idtransaksii) VALUES ('$angkaidtransaksii')");
            header('location:index.php');
        } else {
            echo 'Gagal Menambahkan Transaksi';
        }
    } else {
        
    }
}


// Menghapus Barang dari detail transaksi
if(isset($_POST['hapusprodukdetailtransaksi'])){
    $idproduk = $_POST['idproduk'];

    $hapus = mysqli_query($koneksi,"DELETE FROM detail_transaksi WHERE idproduk='$idproduk'and idtransaksii=(SELECT idtransaksii FROM detail_transaksi ORDER BY idtransaksii DESC LIMIT 1);");
    if ($hapus){
        header('location:index.php');
    } else {
        echo "<script type='text/javascript'>
                alert('Gagal Menghapus Produk!');
                window.location.href = 'index.php';
             </script>";
    }
}
// Update Jumlah Barang Transaksi
if(isset($_POST['updateprodukdetailtransaksi'])){
    $idproduk = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];
    $jumlah = $_POST['jumlah'];

    $update = mysqli_query($koneksi,"UPDATE detail_transaksi SET jumlah='$jumlah'WHERE idproduk='$idproduk'and idtransaksii=(SELECT idtransaksii FROM detail_transaksi ORDER BY idtransaksii DESC LIMIT 1);");
    if ($update){
        header('location:index.php');
    } else {
        echo "<script type='text/javascript'>
                alert('Gagal Meng-Update Produk!');
                window.location.href = 'index.php';
             </script>";
    }
}

?>