<?php
session_start();

$duplikasiproduk = '';

//Konek ke Database
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "retail";
$koneksi = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

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

?>