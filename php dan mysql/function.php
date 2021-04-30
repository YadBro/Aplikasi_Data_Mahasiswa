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

    // htmlspecialchars adalah sebuah fungsi yang agar sesuatu yang diinput html menjadi string / tidak dapat di eksekusi.
    // htmlspecialchars berguna agar yang di input bukan berupa code html
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);


    // upload gambar dan membuat function upload
    $gambar = upload();
    // Mengecek apakah gambar di upload atau tidak apabila tidak query tidak di jalankan
    if( !$gambar ){
        return false;
    }

    /* upload adalah fungsi dalam php untuk mengecek:
    1. Gambar di upload
    2. Mengirimkan nama gambar pada variablenya

    Apabila fungsi uploadnya gagal tidak ada nama yang dikirimkan

    */
    // query insert data
    $query  = "INSERT INTO mahasiswa VALUES
            (
                '', '$nrp', '$nama', '$email', '$jurusan', '$gambar'
            )";
    mysqli_query($konek, $query);

    return mysqli_affected_rows($konek);
}


function upload(){
    /*
    Isi dari $_FILES tadi di tambah.php:
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

    keterangan dari $_FILES input gambar:
        //  
        error = 0 <- tidak ada error
        error = 4 <- tidak ada file yang di upload
        //

        Angka size itu dari ukuran bite seperti contoh yang diatas
        ["size"]=>
        int(28283) = 2mb lebih

    */
    // Membuat variable $namaFile untuk menyimpan nama gambar yang di input user!
    // $_FILES['gambar'] ini di dapatkan dari name yang ada dalam form input type file yang bernamakan gambar lihat di tambah.php
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    /* cek apakah tidak ada gambar yang di upload
    if ( $error === 4 ){
        echo "<script>
            alert('Silahkan pilih gambar terlebih dahulu!');      
        </script>
        ";
        return false;
        // mengembalikan nilai False pada error
    }

    kalau ingin lebih simple masukkan atribut required saja pada atribut inputnya!
 

    cek apakah yang di upload agar berupa gambar(atau yang lainnya) agar meminimalisir user mengirimkan yang aneh misalkan berupa script hacking

    cara mengeceknya kita melihat dari eksteksinya file yang diupload itu apa
    dan kita bisa menentukan file apa yang bisa di upload oleh user
    (yang boleh di upload apa saja).
    */
    $ekstensiGambarValid = ['jpg','jpeg','png'];

    // sebagai contoh format file $ekstensiGambarValid
    
    //$ekstensiGambar = explode(".",$namaFile);
    
    /* $ekstensiGambar mengambil nama file dari $namaFile,
    Gunakan fungsi explode dari PHP untuk memecah string menjadi array

    terdapat 2 parameter dari explode(delimiter,string):
    1. delimiter(pembatas): tanda apa yang ingin di batasi
    2. string: string mana yang ingin di pecah

    Contoh:
    isi dari $namaFile = "beaconcream.png" terdapat .(titik) kita gunakan .(titik) tersebut menjadi pembatas
    lalu kita masukkan pada explode(".", $namaFile)
    maka hasilnya dari:
    beaconcream.png =(menjadi) ["beaconcream","png"] <- hasilnya akan menjadi array
    */

    // ambil nama format dari $namaFile menggunakan fungsi end() dari PHP
    
    
    //$ambilformat = end($ekstensiGambar);

    
    // maka hasilnya png atau nama formatnya kalau di python itu ada yang namanya slice

    // !!! LEBIH EFEKTIF MENGGUNAKAN fungsi pathinfo() dari PHP

    $ambilformat = pathinfo($namaFile);

    /*
    isi dari $ambilformat:

        array(4) {
        ["dirname"]=>
        string(1) "."
        ["basename"]=>
        string(10) "invite.PNG"
        ["extension"]=>
        string(3) "PNG"
        ["filename"]=>
        string(6) "invite"
        }
    */
    

    /* selanjutnya antisipasi dari file yang di upload dari user misalnya yadi.PNG(huruf besar)
    agar menjadi png (huruf kecil) atau agar sesuai dari nama format apa yang kita tentukan tadi
    di awal yaitu $ekstensiGambarValid. Untuk melakukan hal tersebut gunakan fungsi dari PHP yaitu
    strtolower() <- memaksa apapun huruf kapital menjadi huruf kecil
    */
    
    $ekstensiGambar = strtolower(($ambilformat['extension']));

    

    /* sekarang cek apakah ada file yang di upload dari user dengan apa yang kita tentukan formatnya
     di $ekstensiGambarValid gunakan fungsi in_array() untuk mengecek apakah ada sebuah string dari
     user dengan yang ada di array kita $ekstensiGambarValid

    terdapat 2 parameter dari in_array(needle,haystack):
    1. needle(jarum): apa yang ingin di jadikan jarum, misalkan $ekstensiGambar(nama gambar yang telah kita pecah dan mengambil nama format)
    2. haystack(jerami): apa yang ingin di jadikan jerami, misalnya $ekstensiGambarValid(sebuah array yang berisikan nama format yang telah kita tentukan)
    
    jadi istilahnya adalah mencari jarum di dalam jerami
    atau ibarat yang telah kita buat adalah mencari nama string gambar di dalam format array yang kita buat

    fungsi in_array() menghasilkan boolean(true,false): jika false maka tidak ada didalam jerami, jika true maka ada dalam jerami
     */ 

    

    if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){
        echo "<script>
            alert('Yang anda upload bukan gambar! karena .".$ambilformat." bukan format yang di tentukan!');
        </script>
        ";
        return false;
    }

    // selanjutnya cek jika file upload nya terlalu besar ini penting agar penyimpanan kalian tidak berat!
    // ini dalam bite
    if( $ukuranFile > 1000000){
        echo "<script>
            alert('Ukurang gambar terlalu besar!');
        </script>
        ";
        return false;
    }

    /* 
        Terakhir lolos pengecekan, apabila lolos kita pindahkan gambar yang di upload user ke folder
    yang kita tentukan!.
        Gunakan fungsi move_uploaded_file() dari PHP
    
    terdapat 2 parameter dari move_uploaded_file(filename,destination):
    1. filename(nama file)
    2. destination(tujuan file akan di simpan dimana)

    // sebelum itu kita generate nama gambar baru agar meminimalisir nama gambar yang sama tapi gambarnya berbeda
    gunakan fungsi uniqid();
    */
    $namaFileBaru = uniqid();
    $namaFileBaru .= ".";
    $namaFileBaru .= $ekstensiGambar;


    move_uploaded_file($tmpName,"../img/".$namaFileBaru);

    return $namaFileBaru;
    // mengembalika file ke $gambar



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
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    }else{
        $gambar = upload();
    }

    
    
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

