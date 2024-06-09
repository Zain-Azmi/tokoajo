<?php
include 'function.php';

$sqlbulan= "SELECT DATE_FORMAT(tanggaltransaksi, '%Y-%m') as bulan, SUM(jumlahtransaksi) as total_pembelian
        FROM transaksi
        GROUP BY bulan
        ORDER BY bulan";
$resultbulan = $koneksi->query($sqlbulan);

$databulan = array();

if ($resultbulan->num_rows > 0) {
    while($rowbulan = $resultbulannulsn->fetch_assoc()) {
        $databulan[] = $rowbulan;
    }
} else {
    echo json_encode(['error' => 'No data found']); // Jika tidak ada hasil, kirimkan pesan error
    exit;
}

$koneksi->close();

echo json_encode($databulan);
?>
