<?php
// Load file koneksi.php
include "koneksi.php";
// Ambil Data yang Dikirim dari Form
$nama = $_POST['nama'];
$nis = $_POST['nis'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$jurusan = $_POST['jurusan'];
$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];
// Rename nama fotonya dengan menambahkan tanggal dan jam upload
$fotobaru = date('dmYHis').$foto;
// Set path folder tempat menyimpan fotonya
$path = "images/".$fotobaru;
// Proses upload
if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
  // Proses simpan ke Database
  $sql = $pdo->prepare("INSERT INTO tb_ukk(nama, nis, jenis_kelamin, jurusan, foto) VALUES(:nama,:nis,:jenis_kelamin,:jurusan,:foto)");
  $sql->bindParam(':nama', $nama);
  $sql->bindParam(':nis', $nis);
  $sql->bindParam(':jenis_kelamin', $jenis_kelamin);
  $sql->bindParam(':jurusan', $jurusan);
  $sql->bindParam(':foto', $fotobaru);
  $sql->execute(); // Eksekusi query insert
  if($sql){ // Cek jika proses simpan ke database sukses atau tidak
    // Jika Sukses, Lakukan :
    header("location: index.php"); // Redirect ke halaman index.php
  }else{
    // Jika Gagal, Lakukan :
    echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
    echo "<br><a href='form_simpan.php'>Kembali Ke Form</a>";
  }
}else{
  // Jika gambar gagal diupload, Lakukan :
  echo "Maaf, Gambar gagal untuk diupload.";
  echo "<br><a href='form_simpan.php'>Kembali Ke Form</a>";
}
?>