<?php

require_once __DIR__ . '/../config/koneksi.php';

/* AMBIL DATA */

$nama      = trim($_POST['nama_menu']);
$harga     = trim($_POST['harga']);
$stok      = trim($_POST['stok']);
$kategori  = trim($_POST['id_kategori']);

/* VALIDASI */

if(
    $nama == '' ||
    $harga == '' ||
    $stok == '' ||
    $kategori == ''
){

    header(
        "Location:../admin/tambah_menu.php?error=1"
    );

    exit;

}

/* CEK GAMBAR */

if(
    !isset($_FILES['gambar']) ||
    $_FILES['gambar']['name'] == ''
){

    header(
        "Location:../admin/tambah_menu.php?gambar=0"
    );

    exit;

}

/* NAMA FILE */

$gambar =
    time().'_'.
    basename($_FILES['gambar']['name']);

/* UPLOAD */

$upload = move_uploaded_file(
    $_FILES['gambar']['tmp_name'],
    '../assets/img/'.$gambar
);

/* JIKA GAGAL */

if(!$upload){

    header(
        "Location:../admin/tambah_menu.php?upload=0"
    );

    exit;

}

/* SIMPAN */

mysqli_query($conn,"
INSERT INTO menu
(
    nama_menu,
    harga,
    stok,
    gambar,
    id_kategori
)
VALUES
(
    '$nama',
    '$harga',
    '$stok',
    '$gambar',
    '$kategori'
)
");

/* BERHASIL */

header(
    "Location:../admin/menu.php?tambah=1"
);

exit;

?>

