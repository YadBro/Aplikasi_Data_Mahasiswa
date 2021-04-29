<?php
$host   =   "localhost";
$username   =   "root";
$password   =   "";
$database   =   "phpdasar";

$konek=mysqli_connect($host,$username,$password,$database);
    if(mysqli_connect_error()){
        echo "Koneksi gagal: ".mysqli_connect_error();
    }


function query($query){
    global $konek;
    $result = mysqli_query($konek, $query);
    $rows  = [];
    while( $row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }   
    return $rows;
}


function tambah($data){
    global $konek;
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambar = htmlspecialchars($data["gambar"]);
    
    // query insert data
    $query  = "INSERT INTO mahasiswa VALUES
            (
                '', '$nrp', '$nama', '$email', '$jurusan', '$gambar'
            )";
    mysqli_query($konek, $query);

    return mysqli_affected_rows($konek);
}

function hapus($id){
    global $konek;
    mysqli_query($konek,"DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($konek);
}


function ubah($data){
    global $konek;
    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambar = htmlspecialchars($data["gambar"]);
    
    // query insert data
    $query  = "UPDATE mahasiswa SET
        nrp = '$nrp',
        nama = '$nama',
        email = '$email',
        jurusan = '$jurusan', 
        gambar = '$gambar'

        WHERE id = $id
    ";
    mysqli_query($konek, $query);

    return mysqli_affected_rows($konek);
}


function cari($keyword){
    $query = "SELECT * FROM mahasiswa
            WHERE
            nama LIKE '%$keyword%' OR
            email LIKE '%$keyword%' OR
            nrp LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%'
    ";
    return query($query);
}


?>

