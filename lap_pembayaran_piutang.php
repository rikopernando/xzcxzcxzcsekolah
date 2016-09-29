<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM pembayaran_piutang");

 ?>

<div class="container">

 <h3><b>DAFTAR DATA PEMBAYARAN PIUTANG</b></h3><hr>


<div class="dropdown">
             <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:150px"> Jenis Laporan <span class="caret"></span></button>

             <ul class="dropdown-menu">
				<li><a href="lap_pembayaran_piutang_rekap.php"> Laporan Pembayaran Piutang Rekap</a></li> 
		


             </ul>
</div> <!--/ dropdown-->


<br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Kode Pelanggan </th>
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
</span>
</div> <!--/ responsive-->
</div> <!--/ container-->

		<script>
		
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});
		</script>

<?php include 'footer.php'; ?>