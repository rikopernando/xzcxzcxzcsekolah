<?php
include 'sanitasi.php';
include 'db.php';


$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$no_faktur = stringdoang($_POST['no_faktur']);
$no_faktur_retur = stringdoang($_POST['no_faktur_retur']);

$select_hpp = $db->query("SELECT SUM(hm.sisa) + SUM(trp.jumlah_retur) AS sisa FROM hpp_masuk hm INNER JOIN detail_retur_pembelian trp ON hm.no_faktur = trp.no_faktur_pembelian WHERE hm.kode_barang = '$kode_barang' AND hm.no_faktur = '$no_faktur' AND trp.no_faktur_retur = '$no_faktur_retur' ORDER BY hm.id DESC LIMIT 1");
$data = mysqli_fetch_array($select_hpp);

$a = $data['sisa'] - $jumlah_baru;

if ($a  < 0) {
      echo "ya";
}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
?>