<?php
session_start();

//Konek ke Database
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "retail";
$koneksi = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

$query = "SELECT * FROM idtransaksi ORDER BY nomor DESC LIMIT 1";
$hasilidtransaksii = mysqli_query($koneksi, $query);
$pidtransaksii=mysqli_fetch_array($hasilidtransaksii);
$idtransaksii=$pidtransaksii['idtransaksii'];

//Tambah Barang ke Inventaris
if(isset($_POST['tambahprodukbaru'])){
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $addtotable = mysqli_query($koneksi,"insert into produk (namaproduk, harga, stok) values('$namaproduk','$harga','$stok')");
    if ($addtotable){
        header('location:inventaris.php');
    } else {
        echo 'Gagal Menambahkan Barang';
    }
}
if(isset($_POST['tambahprodukkasir'])){
    $idproduk = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];


    $addtotable = mysqli_query($koneksi,"insert into detail_transaksi (idtransaksii,idproduk,namaproduk, harga, jumlah) values('$idtransaksii','$idproduk','$namaproduk','$harga','$jumlah')");
    if ($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal Menambahkan Barang';
    }

}
if(isset($_POST['tambahlaporantransaksi'])){
    $angkaidtransaksii=$idtransaksii+1;
    $addtotableidtransaksii = mysqli_query($koneksi,"insert into idtransaksi (idtransaksii) values('$angkaidtransaksii')");



}

?>