<?php
//Konek ke Database
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "retail";
$koneksi = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
// Mengambil data pembelian per bulan
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

// Mengambil data pembelian per hari
$sqlhari = "SELECT tanggaltransaksi as tanggal, SUM(jumlahtransaksi) as total_pembelian
        FROM transaksi
        GROUP BY tanggal
        ORDER BY tanggal";
$resulthari = $koneksi->query($sqlhari);

$datahari = array();

if ($resulthari->num_rows > 0) {
    while($rowhari = $resulthari->fetch_assoc()) {
        $datahari[] = $rowhari;
    }
} else {
    echo json_encode(['error' => 'No data found']); // Jika tidak ada hasil, kirimkan pesan error
    exit;
}

// Gabungkan data bulan dan data hari ke dalam satu array
$data_combined = array(
    'bulan' => $data,
    'hari' => $datahari
);

// Outputkan data dalam format JSON
echo json_encode($data_combined);

?>