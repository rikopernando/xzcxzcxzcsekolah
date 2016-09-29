<?php include 'session_login.php';




//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';




 ?>

<div class="container">

<h2>Kartu Stok</h2>
<br><br><br>


        <!-- membuat tombol agar menampilkan modal -->
        <button type="button" class="btn btn-warning btn-md" id="cari_produk" data-toggle="modal" data-target="#my_Modal"><span class="glyphicon glyphicon-search"> </span> Cari Produk</button>
        <br><br>
        <!-- Tampilan Modal -->
        <div id="my_Modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        
        <!-- Isi Modal-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Barang</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        
        <!--perintah agar modal update-->
        <span class="modal_baru">
          <div class="table-responsive">                             <!-- membuat agar ada garis pada tabel, disetiap kolom-->
 <table id="tableuser" class="table table-bordered">

        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
        <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Harga Jual </th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Status </th>
            <th> Suplier </th>
            <th> Foto </th>
        
        </thead> <!-- tag penutup tabel -->
        
        <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
<?php


        
        $perintah = $db->query("SELECT * FROM barang");
        
        //menyimpan data sementara yang ada pada $perintah
        while ($data1 = mysqli_fetch_array($perintah))
        {
        
        // menampilkan data
        echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."'>
        
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>
            <td>". rp($data1['harga_beli']) ."</td>
            <td>". rp($data1['harga_jual']) ."</td>";
            
            
// mencari jumlah Barang
            $query0 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_pembelian FROM detail_pembelian WHERE kode_barang = '$data1[kode_barang]'");
            $cek0 = mysqli_fetch_array($query0);
            $jumlah_pembelian = $cek0['jumlah_pembelian'];

            $query1 = $db->query("SELECT SUM(jumlah) AS jumlah_item_masuk FROM detail_item_masuk WHERE kode_barang = '$data1[kode_barang]'");
            $cek1 = mysqli_fetch_array($query1);
            $jumlah_item_masuk = $cek1['jumlah_item_masuk'];

            $query2 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_penjualan FROM detail_retur_penjualan WHERE kode_barang = '$data1[kode_barang]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_retur_penjualan = $cek2['jumlah_retur_penjualan'];

            $query20 = $db->query("SELECT SUM(jumlah_awal) AS jumlah_stok_awal FROM stok_awal WHERE kode_barang = '$data1[kode_barang]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_stok_awal = $cek20['jumlah_stok_awal'];

            $query200 = $db->query("SELECT SUM(selisih_fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$data1[kode_barang]'");
            $cek200 = mysqli_fetch_array($query200);
            $jumlah_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $jumlah_fisik;


 

            $query3 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_penjualan FROM detail_penjualan WHERE kode_barang = '$data1[kode_barang]'");
            $cek3 = mysqli_fetch_array($query3);
            $jumlah_penjualan = $cek3['jumlah_penjualan'];


            $query4 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM detail_item_keluar WHERE kode_barang = '$data1[kode_barang]'");
            $cek4 = mysqli_fetch_array($query4);
            $jumlah_item_keluar = $cek4['jumlah_item_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_pembelian FROM detail_retur_pembelian WHERE kode_barang = '$data1[kode_barang]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_retur_pembelian = $cek5['jumlah_retur_pembelian'];


 



//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;

            $stok_barang = $total_1 - $total_2;
            
            
            
            
            
            echo "<td>". $stok_barang ."</td>
            <td>". $data1['satuan'] ."</td>
            <td>". $data1['kategori'] ."</td>
            <td>". $data1['status'] ."</td>
            <td>". $data1['suplier'] ."</td>
            
            <td><img src='save_picture/". $data1['foto'] ."' height='20px' width='40px' ></td>
            </tr>";
      
         }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
    
        </tbody> <!--tag penutup tbody-->
        
        </table> <!-- tag penutup table-->
        </div>
</span>
        	
</div> <!-- tag penutup modal body -->
        
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
        </div>
        
        </div>
        </div>




<form action="proses_kartu_stok.php" role="form" method="post">
		<div class="row">
				<div class="form-inline">
					<div class="form-group">
					<label> Kode Produk </label><br>
					<input type="text" name="kode_produk" id="kode_produk" placeholder="Kode Produk"  autocomplete="off" class="form-control" >
					</div>



					<div class="form-group">
					<label> Nama Produk </label><br>
					<input type="text" name="nama_produk" id="nama_produk" placeholder="Nama Produk" class="form-control" readonly="">
					</div>

					<div class="form-group">
					<label> Bulan </label><br>
					<select type="text" name="bulan" id="bulan" class="form-control" required="">
						<option value=""> --SILAKAN PILIH-- </option>
						<option value="1"> Januari </option>
						<option value="2"> Februari </option>
						<option value="3"> Maret </option>
						<option value="4"> April </option>
						<option value="5"> Mei </option>
						<option value="6"> Juni </option>
						<option value="7"> Juli </option>
						<option value="8"> Agustus </option>
						<option value="9"> September </option>
						<option value="10"> Oktober </option>
						<option value="11"> November </option>
						<option value="12"> Desember </option>
					</select> 
					</div>


					<div class="form-group">
					<label> Tahun </label><br>
					<select type="text" name="tahun" id="tahun" class="form-control" required="">
					<option value=""> --SILAKAN PILIH-- </option>
						
						<option> 2015 </option>
						<option> 2016 </option>
						<option> 2017 </option>
						<option> 2018 </option>
						<option> 2019 </option>
						<option> 2020 </option>
						<option> 2021 </option>
						<option> 2022 </option>
                        <option> 2023 </option>
                        <option> 2024 </option>
                        <option> 2025 </option>
					</select> 
					</div>


					<div class="form-group">
					<label> <br> </label><br>
					<button type="submit" id="submit" class="btn btn-info"><span class="glyphicon glyphicon-plus"> </span> Submit</button>
					</div>


				</div>
		</div>
</form>
<br><br>

<span id="result">
<table class="table table-bordered">
	
	<thead>
		
		<th>No Faktur</th>
        <th>Kode Barang</th>
		<th> Tanggal </th>
		<th> Tipe </th>
		<th> Jumlah Masuk </th>
		<th> Jumlah Keluar </th>
		<th> Saldo </th>
        <th> Suplier / Pelanggan </th>

	</thead>

	<tbody>
		

	</tbody>
</table>
</span>

</div><!--/container-->

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  


</script>


<!-- untuk memasukan perintah javascript -->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_produk").value = $(this).attr('data-kode');
  document.getElementById("nama_produk").value = $(this).attr('nama-barang');

  
  $('#my_Modal').modal('hide');
  });
   

  </script> <!--tag penutup perintah java script-->


  <script type="text/javascript">
      
      $(document).ready(function(){
        $("#kode_produk").keyup(function(){

          var kode_barang = $(this).val();

      $.getJSON('lihat_kartu_stok.php',{kode_barang:$(this).val()}, function(json){
      
      if (json == null)
      {
        
        $('#nama_produk').val('');
      }

      else 
      {
        $('#nama_produk').val(json.nama_barang);
      }
                                              
        });
        
        });
        });


  </script>


<script type="text/javascript">

$("#submit").click(function(){

    var kode_barang = $("#kode_produk").val();
    var bulan = $("#bulan").val();
    var tahun = $("#tahun").val();    
    
    $.post("proses_kartu_stok.php",{kode_barang:kode_barang,bulan:bulan,tahun:tahun},function(info) {
   
   $("#result").html(info);
    $("#bulan").val('');
    $("#tahun").val('');


    });
              $('form').submit(function(){
              
              return false;
              });


    });


</script>
<!--

  <script>
  $(function() {
    $( "#periode" ).datepicker({
      altField: "#periode_1", altFormat: " MM, yy", changeMonth: true, changeYear: true, yearRange: "1990:2020"
    });
  });
  </script> -->

  <?php include 'footer.php'; ?>