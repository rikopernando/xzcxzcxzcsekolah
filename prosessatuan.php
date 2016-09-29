<?php 

//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';

	//mengirim data sesuai dengan variabel dengan metode POST


// menambah data yang ada pada tabel satuan berdasarka id dan nama
$perintah = $db->prepare("INSERT INTO satuan (id,nama,nama_cetak,dari_satuan,qty)
			VALUES (?,?,?,?,?)");

$perintah->bind_param("ssssi",
	$id, $nama, $nama_cetak, $dari_satuan, $qty);

	$id = angkadoang($_POST['id']);
	$nama = stringdoang($_POST['nama']);
	$nama_cetak = stringdoang($_POST['nama_cetak']);
	$dari_satuan = stringdoang($_POST['dari_satuan']);
	$qty = angkadoang($_POST['qty']);

$perintah->execute();

if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   echo 'sukses';
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>