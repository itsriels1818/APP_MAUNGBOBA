<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

include '../config/koneksi.php';

/* KATEGORI */

$kategori = mysqli_query($conn,"
SELECT *
FROM kategori
ORDER BY nama_kategori ASC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Tambah Menu</title>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="../assets/css/admin.css">

</head>

<body>

<div class="form-page">

<div class="form-card">

<div class="form-header">

<h2>Tambah Menu</h2>

<p>
Tambahkan menu baru kedai
</p>

</div>

<form
action="../process/tambah_menu.php"
method="POST"
enctype="multipart/form-data">

<div class="form-group">

<label>Nama Menu</label>

<input
type="text"
name="nama_menu"
required>

</div>

<div class="form-group">

<label>Harga</label>

<input
type="number"
name="harga"
required>

</div>

<div class="form-group">

<label>Stok</label>

<input
type="number"
name="stok"
required>

</div>

<div class="form-group">

<label>Kategori</label>

<select
name="id_kategori"
required>

<option value="">
Pilih Kategori
</option>

<?php while($k = mysqli_fetch_array($kategori)){ ?>

<option
value="<?php echo $k['id_kategori']; ?>">

<?php
echo $k['nama_kategori'];
?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Upload Gambar</label>

<input
type="file"
name="gambar"
required>

</div>

<div class="form-action">

<button type="submit">

Tambah Menu

</button>

<a href="menu.php">

Kembali

</a>

</div>

</form>

</div>

</div>

</body>
</html>