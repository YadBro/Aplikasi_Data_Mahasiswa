<?php
session_start();
if (!isset($_SESSION["login"])){
  header("Location: login.php");
  exit;
}
require 'function.php';


// ambil data di URL
$id = $_GET["id"];
if ($id === NULL){
    header("Location: index.php");
    exit;
  }

// query data mahasiswa berdasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];
    // cek apakah tombol submit sudah di tekan atau belum
    if( isset($_POST["submit"]) ) {
        
    

        // cek apakah berhasil diubah atau tidak
        if(ubah($_POST) > 0){
            echo "
                <script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'index.php';
                </script>
            ";

        }if ($_POST["submit"] == "") {
            echo "
            <script>
                alert('Tidak ada data yang diubah!');
                document.location.href = 'index.php';
            </script>
        ";
        }else{
            echo "
            <script>
                alert('Data gagal diubah!');
                document.location.href = 'ubah.php';
            </script>
        ";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Mahasiswa</title>
</head>
<body>
    <h1>Ubah Data Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $mhs["id"];?>">
    <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"];?>">

        <ul>
            <li>
                <label for="nrp">NRP :</label>
                <input type="text" name="nrp" id="nrp" required value="<?= $mhs["nrp"];?>">
            </li>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required value="<?= $mhs["nama"];?>">
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required value="<?= $mhs["email"];?>">
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" required value="<?= $mhs["jurusan"];?>">
            </li>
            <li>
                <label for="gambar">Gambar :</label><br>
                <img src="../img/<?= $mhs['gambar'];?>" alt="" width="70" height="70"><br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah Data</button>
            </li>
        </ul>
        

    </form>
    
</body>
</html>