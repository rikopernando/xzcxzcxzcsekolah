<?php 


include 'db.php';

 $no_faktur = $_POST['no_faktur'];


 ?>



    <style>
table {
    border-collapse: collapse;
    width: 100%;
}

.th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

.th {
    background-color: #4CAF50;
    color: white;
}
</style>

<h4>Maaf No Transaksi <strong><?php echo $no_faktur; ?></strong> tidak dapat dihapus, karena barang yang diretur telah dikembalikan atau dijual kembali.</h4>







