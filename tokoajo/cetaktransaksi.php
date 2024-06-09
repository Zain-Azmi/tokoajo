<?php
require 'function.php';
?>
<html>
<head>
  <title>Data Produk Toko Ajo Lpn</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="container">
    <br>
    <h2>Data Produk Toko Ajo Lpn</h2>
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
                                       $get = mysqli_query($koneksi,"SELECT * FROM detail_transaksi WHERE idtransaksii = (SELECT idtransaksii FROM idtransaksi ORDER BY nomor DESC LIMIT 1);");
                                       $jumlahtransaksikasir=0;
                                       $tulisanjumlahtransaksikasir="Rp 0";
                                       while ($p=mysqli_fetch_array($get)){
                                        $idproduk=$p['idproduk'];
                                        $namaproduk=$p['namaproduk'];
                                        $harga=$p['harga'];
                                        $jumlah=$p['jumlah'];
                                        $subtotal=$harga*$jumlah;
                                        
                                    
                                       ?>
                                            <tr>
                                                <td><?=$idproduk;?></td>
                                                <td><?=$namaproduk;?></td>
                                                <td>Rp <?php echo number_format ($harga);?></td>
                                                <td><?php echo $jumlah;?></td>
                                                <td>Rp <?php echo number_format($subtotal);?></td>
                                            <tr>
                                        <?php
                                       };
                                       ?>

            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
</body>
</html>
