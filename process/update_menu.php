<?php

require_once __DIR__ . '/../config/koneksi.php';

/* DATA */

$id = $_POST['id_menu'];

$nama = $_POST['nama_menu'];

$harga = $_POST['harga'];

$stok = $_POST['stok'];

$kategori = $_POST['id_kategori'];

/* DATA LAMA */

$data = mysqli_fetch_array(
mysqli_query($conn,"
SELECT *
FROM menu
WHERE id_menu='$id'
")
);

$gambar = $data['gambar'];

/* UPLOAD GAMBAR */

if(
isset($_FILES['gambar']) &&
$_FILES['gambar']['name'] != ''
){

$namaFile =
time().'_'.
$_FILES['gambar']['name'];

$tmp =
$_FILES['gambar']['tmp_name'];

move_uploaded_file(
$tmp,
'../assets/img/'.$namaFile
);

$gambar = $namaFile;

}

/* UPDATE */

mysqli_query($conn,"
UPDATE menu
SET
nama_menu='$nama',
harga='$harga',
stok='$stok',
id_kategori='$kategori',
gambar='$gambar'
WHERE id_menu='$id'
");

/* REDIRECT */

header(
"Location:../admin/menu.php?success=1"
);

?>