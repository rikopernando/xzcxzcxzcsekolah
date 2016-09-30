<?php 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';

    $session_id = $_POST['session_id'];

    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $jumlah_barang = angkadoang($_POST['jumlah_barang']);
    $satuan = stringdoang($_POST['satuan']);
    $harga = angkadoang($_POST['harga']);
    $harga_baru = angkadoang($_POST['harga_baru']);
    $tax = stringdoang($_POST['tax']);

    $potongan = stringdoang($_POST['potongan']);
    $a = $harga * $jumlah_barang;


          if(strpos($potongan, "%") !== false)
          {
               $potongan_jadi = $a * $potongan / 100;
               $potongan_tampil = $potongan_jadi;
          }
          else{

             $potongan_jadi = $potongan;
              $potongan_tampil = $potongan;
          }
    $tax = stringdoang($_POST['tax']);
    $satu = 1;
    $x = $a - $potongan_tampil;

        $hasil_tax = $satu + ($tax / 100); echo "<br>";
        
        $hasil_tax2 = $x / $hasil_tax; echo "<br>";

        $tax_persen = $x - $hasil_tax2; echo "<br>";
        
       $tax_persen = round($tax_persen);


    if ( $harga != $harga_baru) {

      $query00 = $db->query("UPDATE barang SET harga_beli = '$harga_baru' WHERE kode_barang = '$kode_barang'");
      $harga_beli = $harga_baru;
    }

else {

      $harga_beli = $harga;

    }

    // menampilkan data yang ada dari tabel tbs_pembelian berdasarkan kode barang
    $cek = $db->query("SELECT * FROM tbs_pembelian WHERE session_id = '$session_id' AND kode_barang = '$kode_barang'");
    // menyimpan data sementara berupa baris yang dijalankan dari $cek
    $jumlah = mysqli_num_rows($cek);
    // jika $jumlah >0 maka akan menjalakan perintah $query1 jika tidak maka akan menjalankan perintah $perintah
    
    if ($jumlah > 0)
    {

        $query1 = $db->prepare("UPDATE tbs_pembelian SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ?, tax = ? WHERE kode_barang = ? AND session_id = ?");

        $query1->bind_param("iissss",
            $jumlah_barang, $subtotal, $potongan_tampil, $tax_persen, $kode_barang, $session_id);

            
            $jumlah_barang = angkadoang($_POST['jumlah_barang']);
            $kode_barang = stringdoang($_POST['kode_barang']);
            $subtotal = $harga_beli * $jumlah_barang - $potongan_jadi + $tax_persen;

        $query1->execute();


    }
    else
    {
        $perintah = $db->prepare("INSERT INTO tbs_pembelian (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax) VALUES (?,?,?,?,?,?,?,?,?)");

        $perintah->bind_param("sssisiisi",
          $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga_beli, $subtotal, $potongan_tampil, $tax_persen);
          
          $kode_barang = stringdoang($_POST['kode_barang']);
          $nama_barang = stringdoang($_POST['nama_barang']);
          $jumlah_barang = angkadoang($_POST['jumlah_barang']);
          $satuan = stringdoang($_POST['satuan']);
          $subtotal = $harga_beli * $jumlah_barang - $potongan_jadi;

        $perintah->execute();

        
if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   
}

    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>


