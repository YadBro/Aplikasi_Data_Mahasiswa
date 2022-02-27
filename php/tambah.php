<?php
session_start();
if (!isset($_SESSION["login"])){
  header("Location: login.php");
  exit;
} 
require 'function.php';
    // cek apakah tombol submit sudah di tekan atau belum
    if( isset($_POST["submit"]) ) {
        
        /* Melihat isi dari $_POST $_FILES (debug)
        
        var_dump($_POST); 
        var_dump($_FILES);
        die;

         Fungsi var_dump digunakan untuk mencetak output ke browser
         Fungsi die adalah untuk mengakhiri eksekusi baris.
        Sehingga baris yang di bawahnya tidak tereksekusi.



            Isi dari $_POST:
            Ada 5 array (nrp,nama,email,jurusan,submit)
            array(5) {
            ["nrp"]=>
            string(4) "dsad"
            ["nama"]=>
            string(4) "weqe"
            ["email"]=>
            string(5) "sadas"
            ["jurusan"]=>
            string(4) "wqeq"
            ["submit"]=>
            string(0) ""
            }

            Isi dari $_FILES:
            Ada 1 array (gambar)
            array(1) {
            ["gambar"]=>
                //Ada 5 buah element array dari gambar

                array(5) {
                ["name"]=>
                string(15) "beaconcream.png"
                ["type"]=>
                string(9) "image/png"
                ["tmp_name"]=>
                string(24) "C:\xampp\tmp\phpFC2B.tmp"
                ["error"]=>
                int(0)
                ["size"]=>
                int(28283)
                }
            }

            keterangan dari $_FILES:
                //  
                error = 0 <- tidak ada error
                error = 4 <- tidak ada file yang di upload
                //

                Angka size itu dari ukuran bite seperti contoh yang diatas
                ["size"]=>
                int(28283) = 2mb lebih



        */

        

        // cek apakah berhasil ditambahkan atau tidak
        if(tambah($_POST) > 0){
            echo "
                <script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'index.php';
                </script>
            ";

        }else{
            echo "
            <script>
                alert('Data gagal ditambahkan!');
                document.location.href = 'tambah.php';
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
    <title>Tambah Data Mahasiswa</title>
</head>
<body>
    <h1>Tambah Data Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
    <!-- Agar form di isi dengan type file kita masukkan enctype -->

        <ul>
            <li>
                <label for="nrp">NRP :</label>
                <input type="text" name="nrp" id="nrp" required>
            </li>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required>
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" required>
            </li>
            <li>
                <label for="gambar">Gambar :</label>
                <input type="file" name="gambar" id="gambar" required>
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data</button>
            </li>
        </ul>
        

    </form>
    
</body>
</html>
