<?php
session_start();

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

    $addtotable = mysqli_query($koneksi,"INSERT INTO produk (namaproduk, harga, stok) VALUES('$namaproduk','$harga','$stok')");
    if ($addtotable){
        header('location:inventaris.php');
    } else {
        echo "<script type='text/javascript'>
                alert('Gagal Menambahkan Produk!');
                window.location.href = 'inventaris.php';
             </script>";
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