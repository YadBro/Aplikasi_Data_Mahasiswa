<?php
session_start();
if (!isset($_SESSION["login"])){
  header("Location: login.php");
  exit;
}
// masukkan koneksi database
    require "function.php";

// ambil data dari tabel mahasiswa / query data mahasiswa
    $mahasiswa = query("SELECT * FROM mahasiswa");

// ambil data (fetch) mahasiswa dari object result
// Cara mengambilnya, ada 4 cara:
// 1. mysqli_fetch_row()
// 2. mysqli_fetch_assoc()
// 3. mysqli_fetch_array()
// 4. mysqli_fetch_object()


/*
coba dengan No.1 mysqli_fetch_row() = mengembalikan array numerik
$mhs = mysqli_fetch_row($result);
var_dump($mhs);

yang tampil:

array(6) {
  [0]=>
  string(1) "1"
  [1]=>
  string(13) "Yadi Apriyadi"
  [2]=>
  string(7) "1215021"
  [3]=>
  string(15) "babeh@gmail.com"
  [4]=>
  string(24) "Rekayasa Perangkat Lunak"
  [5]=>
  string(17) "babehganteng.jpeg"
}

*/

/* coba dengan No.2 mysqli_fetch_assoc() = mengembalikan array associative
$mhs = mysqli_fetch_assoc($result);
var_dump($mhs["email"]);

yang tampil:

array(6) {
  ["id"]=>
  string(1) "1"
  ["nama"]=>
  string(13) "Yadi Apriyadi"
  ["nrp"]=>
  string(7) "1215021"
  ["email"]=>
  string(15) "babeh@gmail.com"
  ["jurusan"]=>
  string(24) "Rekayasa Perangkat Lunak"
  ["gambar"]=>
  string(17) "babehganteng.jpeg"
}

*/

/*
coba dengan No.3 mysqli_fetch_array() = mengembalikan keduanya
$mhs = mysqli_fetch_array($result);
var_dump($mhs[3]);

yang tampil:

array(12) {
    [0]=>
    string(1) "1"
    ["id"]=>
    string(1) "1"
    [1]=>
    string(13) "Yadi Apriyadi"
    ["nama"]=>
    string(13) "Yadi Apriyadi"
    [2]=>
    string(7) "1215021"
    ["nrp"]=>
    string(7) "1215021"
    [3]=>
    string(15) "babeh@gmail.com"
    ["email"]=>
    string(15) "babeh@gmail.com"
    [4]=>
    string(24) "Rekayasa Perangkat Lunak"
    ["jurusan"]=>
    string(24) "Rekayasa Perangkat Lunak"
    [5]=>
    string(17) "babehganteng.jpeg"
    ["gambar"]=>
    string(17) "babehganteng.jpeg"
  }

*/

/*
coba dengan No.4 mysqli_fetch_object() = mengembalikan object
$mhs = mysqli_fetch_object($result);
var_dump($mhs->email);

yang tampil


object(stdClass)#3 (6) {
    ["id"]=>
    string(1) "1"
    ["nama"]=>
    string(13) "Yadi Apriyadi"
    ["nrp"]=>
    string(7) "1215021"
    ["email"]=>
    string(15) "babeh@gmail.com"
    ["jurusan"]=>
    string(24) "Rekayasa Perangkat Lunak"
    ["gambar"]=>
    string(17) "babehganteng.jpeg"
  }

*/

//  REKOMENDASI PAKE NO.2 mysqli_fetch_assoc()

// Menampilkan semuanya, menggukan while
/*
while( $mhs = mysqli_fetch_assoc($result) ){
    var_dump($mhs);
};



Hasilnya: <- Tinggal siap di gunakan

array(6) {
  ["id"]=>
  string(1) "1"
  ["nama"]=>
  string(13) "Yadi Apriyadi"
  ["nrp"]=>
  string(7) "1215021"
  ["email"]=>
  string(15) "babeh@gmail.com"
  ["jurusan"]=>
  string(24) "Rekayasa Perangkat Lunak"
  ["gambar"]=>
  string(17) "babehganteng.jpeg"
}
array(6) {
  ["id"]=>
  string(1) "2"
  ["nama"]=>
  string(12) "Babeh tampan"
  ["nrp"]=>
  string(8) "75454154"
  ["email"]=>
  string(18) "babeh424@gmail.com"
  ["jurusan"]=>
  string(19) "Teknik Sepeda Motor"
  ["gambar"]=>
  string(10) "babeh.jpeg"
}
array(6) {
  ["id"]=>
  string(1) "3"
  ["nama"]=>
  string(12) "Putri Hayana"
  ["nrp"]=>
  string(7) "7875412"
  ["email"]=>
  string(15) "galuh@gmail.com"
  ["jurusan"]=>
  string(7) "Elind A"
  ["gambar"]=>
  string(10) "galuh.jpeg"
}
array(6) {
  ["id"]=>
  string(1) "4"
  ["nama"]=>
  string(11) "anjay mabar"
  ["nrp"]=>
  string(6) "524587"
  ["email"]=>
  string(13) "wow@gmail.com"
  ["jurusan"]=>
  string(4) "Meka"
  ["gambar"]=>
  string(8) "jay.jpeg"
}
array(6) {
  ["id"]=>
  string(1) "5"
  ["nama"]=>
  string(14) "Jupri Haryanto"
  ["nrp"]=>
  string(6) "572549"
  ["email"]=>
  string(15) "jupri@gmail.com"
  ["jurusan"]=>
  string(23) "Teknik Kendaraan Ringan"
  ["gambar"]=>
  string(10) "jupri.jpeg"
}

*/

// Tombol cari ditekan
if( isset($_POST["cari"])){
    $mahasiswa = cari($_POST["keyword"]);
    
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>
<a href="logout.php">Logout</a>
    <h1>Daftar Mahasiswa</h1>
    <a href="tambah.php">Tambah Data Mahasiswa</a>
    <br><br>
    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="Masukkan keyword pencarian.." autocomplete="off">
        <button type="submit" name="cari">Cari</button>
    </form>
    <br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NRP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>
        
        <?php $i = 1; ?>
        <?php foreach($mahasiswa as $row) : ?>
        
        

        <tr>
            <td><?= $i; ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id"];?>">Ubah</a>    |
                <a href="hapus.php?id=<?= $row["id"];?>" onclick="return confirm('yakin?');">Hapus</a>
            </td>
            <td><img src="../img/<?= $row["gambar"];?>" width="60" alt=""></td>
            <td><?= $row["nrp"]; ?></td>
            <td><?= $row["nama"]; ?></td>
            <td><?= $row["email"]; ?></td>
            <td><?= $row["jurusan"]; ?></td>
        </tr>
        <?php $i++;?>
        <?php endforeach; ?>


    </table>



</body>
</html>
