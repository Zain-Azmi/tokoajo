<?php
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Toko Ajo Lpn</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
</head>
<body>
<div class="container">
    <br>
    <h2>Laporan Transaksi Toko Ajo Lpn</h2>
    <br>
    <div class="data-tables datatable-dark">
    <table id="datatablesSimple" class="table table-striped">
        <thead>
            <tr>
                <th>IDTransaksi</th>
                <th>Tanggal</th>
                <th>Jumlah Transaksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "retail";
        $koneksi = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        $laporantransaksi = mysqli_query($koneksi, "SELECT * FROM transaksi;");
        while ($plaporantransaksi = mysqli_fetch_array($laporantransaksi)) {
            $idtransaksi = $plaporantransaksi['idtransaksii'];
            $tanggal = $plaporantransaksi['tanggaltransaksi'];
            $jumlaht = $plaporantransaksi['jumlahtransaksi'];
        ?>
            <tr>
                <td><?= $idtransaksi; ?></td>
                <td><?= $tanggal; ?></td>
                <td>Rp <?= number_format($jumlaht); ?></td>
            </tr>
        <?php
        };
        ?>
        </tbody>
    </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
            },
            {
                extend: 'csv',
            },
            {
                extend: 'excel',
            },
            {
                extend: 'pdf',
            },
            {
                extend: 'print',
            }
        ]
    });
});
</script>
</body>
</html>
