<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM pembayaran_piutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");



 ?>

	<style>
	
	tr:nth-child(even){background-color: #f2f2f2}
	
	</style>

<div class="card card-block">

<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Kode Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Cara Bayar </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar </th>
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				$perintah0 = $db->query("SELECT * FROM detail_pembayaran_piutang WHERE no_faktur_pembayaran = '$data1[no_faktur_pembayaran]'");
				$cek = mysqli_fetch_array($perintah0);
			echo "<tr>
			<td>". $data1['no_faktur_pembayaran'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['nama_suplier'] ."</td>
			<td>". $data1['dari_kas'] ."</td>
			<td>". $cek['potongan'] ."</td>
			<td>". rp($data1['total']) ."</td>

			
			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   
		?>
		</tbody>

	</table>
</div>
<br>


       <a href='cetak_lap_pembayaran_piutang_rekap.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success'><i class='fa fa-print'> </i> Cetak Pembayaran Piutang </a>

</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>