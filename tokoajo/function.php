<?php
session_start();

//Konek ke Database
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "retail";
$koneksi = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

//Tambah Barang ke Inventaris
if(isset($_POST['tambahprodukbaru'])){
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $addtotable = mysqli_query($koneksi,"insert into produk (namaproduk, harga, stok) values('$namaproduk','$harga','$stok')");
    if ($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal Menambahkan Barang';
    }
}

?>