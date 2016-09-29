<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];



$query = $db->query("SELECT dp.id, dp.no_faktur, dp.kode_barang, dp.nama_barang, dp.jumlah_barang / sk.konversi AS jumlah_produk, dp.jumlah_barang, dp.satuan, dp.harga, dp.potongan, dp.subtotal, dp.tax, dp.sisa, sk.id_satuan, s.nama, sa.nama AS satuan_asal, SUM(hk.sisa_barang) AS sisa_barang FROM detail_penjualan dp LEFT JOIN satuan_konversi sk ON dp.satuan = sk.id_satuan LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN satuan sa ON dp.asal_satuan = sa.id LEFT JOIN hpp_keluar hk ON dp.no_faktur = hk.no_faktur AND dp.kode_barang = hk.kode_barang WHERE dp.no_faktur = '$no_faktur'");



?>
					<div class="container">
					
					<div class="table-responsive"> 
					<table id="tableuser" class="table table-bordered">
					<thead>
					<th> Nomor Faktur </th>
					<th> Kode Barang </th>
					<th> Nama Barang </th>
					<th> Jumlah Barang </th>
					<th> Satuan </th>
					<th> Harga </th>
					<th> Subtotal </th>
					<th> Potongan </th>
					<th> Tax </th>
      <?php 
             if ($_SESSION['otoritas'] == 'Pimpinan')
             {
             
             
             echo "<th> Hpp </th>";
             }
      ?>

					
					<th> Sisa Barang </th>
					
					
					</thead>
					
					<tbody>
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($query))
					{
					//menampilkan data
					echo "<tr>
					<td>". $data1['no_faktur'] ."</td>
					<td>". $data1['kode_barang'] ."</td>
					<td>". $data1['nama_barang'] ."</td>";

					if ($data1['jumlah_produk'] > 0) {
						echo "<td>". $data1['jumlah_produk'] ."</td>";
					}
					else{
						echo "<td>". $data1['jumlah_barang'] ."</td>";
					}

					echo"<td>". $data1['nama'] ."</td>
					<td>". rp($data1['harga']) ."</td>
					<td>". rp($data1['subtotal']) ."</td>
					<td>". rp($data1['potongan']) ."</td>
					<td>". rp($data1['tax']) ."</td>";

        if ($_SESSION['otoritas'] == 'Pimpinan'){

                echo "<td>". rp($data1['hpp']) ."</td>";
        }

					echo "<td>". $data1['sisa_barang'] ." ".$data1['satuan_asal']."</td>
					</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>
					</tbody>
					
					</table>
					</div>
					</div>