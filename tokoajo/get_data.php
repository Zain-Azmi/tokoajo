<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "retail";
$koneksi = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);


$sql = "SELECT DATE(tanggaltransaksi) as tanggal, SUM(jumlahtransaksi) as total_pembelian
        FROM detail_transaksi
        GROUP BY tanggal
        ORDER BY tanggal";
$result = $koneksi->query($sql);

$datahari = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $datahari[] = $row;
    }
} else {
    echo json_encode(['error' => 'No data found']); // Jika tidak ada hasil, kirimkan pesan error
    exit;
}


// Untuk debugging, tambahkan echo untuk melihat output di browser
echo json_encode($datahari);
?>


