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
// Masukin Data Ke Tabel Detail Transaksi
if(isset($_POST['tambahprodukkasir'])){
    $idproduk = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
    $subtotal =$harga*$jumlah;

    $addtotable = mysqli_query($koneksi,"insert into detail_transaksi (idtransaksii,idproduk,namaproduk, harga, jumlah,sub_total) values('$idtransaksii','$idproduk','$namaproduk','$harga','$jumlah',$subtotal)");
    if ($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal Menambahkan Barang';
    }

}
// Masukin Data Ke Tabel Transaksi
if(isset($_POST['tambahlaporantransaksi'])){
    $jumlahlaporan =$jumlahtransaksi;
    $idtransaksii = $_POST['idtransaksii'];
    $addtotable = mysqli_query($koneksi,"insert into transaksi (idtransaksii,jumlahtransaksi) values('$idtransaksii','$jumlahlaporan')");
    if ($addtotable){
        $angkaidtransaksii=$idtransaksii+1;
    $addtotableidtransaksii = mysqli_query($koneksi,"insert into idtransaksi (idtransaksii) values('$angkaidtransaksii')");
        header('location:index.php');
        $jumlahtransaksi=0;
    } else {
        echo 'Gagal Menambahkan Barang';
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
//ambil data buat diagram perhari

$sql = "SELECT DATE_FORMAT(tanggaltransaksi, '%Y-%m') as bulan, SUM(jumlahtransaksi) as total_pembelian
        FROM transaksi
        GROUP BY bulan
        ORDER BY bulan";
$result = $koneksi->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo json_encode(['error' => 'No data found']); // Jika tidak ada hasil, kirimkan pesan error
}


echo json_encode($data);


?>