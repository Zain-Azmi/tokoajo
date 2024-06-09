<?php
require 'function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
</head>
<body>
    
<?php
$tulisanjumlahtransaksikasir = $_SESSION['tulisanjumlahtransaksikasir'];
?>,

<div class="container">
    <br>
    <h2>Transaksi</h2>
    <br>
    <div class="data-tables datatable-dark">
        <table id="datatablesSimple" class="display">
            <thead>
                <tr>
                    <th>ID Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Sub-Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get = mysqli_query($koneksi, "SELECT * FROM detail_transaksi WHERE idtransaksii = (SELECT idtransaksii FROM idtransaksi ORDER BY nomor DESC LIMIT 1);");
                while ($p = mysqli_fetch_array($get)) {
                    $idproduk = $p['idproduk'];
                    $namaproduk = $p['namaproduk'];
                    $harga = $p['harga'];
                    $jumlah = $p['jumlah'];
                    $subtotal = $harga * $jumlah;
                ?>
                <tr>
                    <td><?=$idproduk;?></td>
                    <td><?=$namaproduk;?></td>
                    <td>Rp <?php echo number_format($harga);?></td>
                    <td><?php echo $jumlah;?></td>
                    <td>Rp <?php echo number_format($subtotal);?></td>
                </tr>
                <?php
                };
                ?>
            </tbody>
        </table>
        <h4>Jumlah Pembayaran</h4>
        <input type="hidden" name="idtransaksii" value="<?=$idtransaksii;?>">
        <input type="hidden" name="jumlahtransaksi" value="<?=$jumlahtransaksikasir;?>"disabled>
        <input type="text" name="tulisanjumlahtransaksi" value="<?=$tulisanjumlahtransaksikasir;?>"disabled>
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
                title: 'Transaksi',
                customize: function (win) {
                    $(win.document.body)
                        .prepend(
                            '<h4>Jumlah Pembayaran: <?php echo $tulisanjumlahtransaksikasir; ?></h4>'
                        );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                extend: 'csv',
                title: 'Transaksi',
                customize: function (win) {
                    $(win.document.body)
                        .prepend(
                            '<h4>Jumlah Pembayaran: <?php echo $tulisanjumlahtransaksikasir; ?></h4>'
                        );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                extend: 'excel',
                title: 'Transaksi',
                customize: function (win) {
                    $(win.document.body)
                        .prepend(
                            '<h4>Jumlah Pembayaran: <?php echo $tulisanjumlahtransaksikasir; ?></h4>'
                        );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
            {
                extend: 'pdf',
                title: 'Transaksi',
                customize: function (doc) {
                    doc.content.splice(0, 0, {
                        text: 'Jumlah Pembayaran: <?php echo $tulisanjumlahtransaksikasir; ?>',
                        margin: [0, 0, 0, 12]
                    });
                }
            },
            {
                extend: 'print',
                title: 'Transaksi',
                customize: function (win) {
                    $(win.document.body)
                        .prepend(
                            '<h4>Jumlah Pembayaran: <?php echo $tulisanjumlahtransaksikasir; ?></h4>'
                        );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]
    });
});
</script>
</body>
</html>
