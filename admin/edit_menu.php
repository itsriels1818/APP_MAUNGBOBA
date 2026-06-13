<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';

/* ID */

$id =
isset($_GET['id'])
? intval($_GET['id'])
: 0;

/* DATA MENU */

$query = mysqli_query($conn,"
SELECT *
FROM menu
WHERE id_menu='$id'
");

$m = mysqli_fetch_array($query);

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

<title>Edit Menu</title>

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

<h2>Edit Menu</h2>

<p>
Perbarui data menu kedai
</p>

</div>

<form
action="../process/update_menu.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id_menu"
value="<?php echo $m['id_menu']; ?>">

<!-- GAMBAR -->

<div class="image-preview">

<img
src="../assets/img/<?php echo $m['gambar']; ?>">

</div>

<!-- NAMA -->

<div class="form-group">

<label>Nama Menu</label>

<input
type="text"
name="nama_menu"
value="<?php echo $m['nama_menu']; ?>"
required>

</div>

<!-- HARGA -->

<div class="form-group">

<label>Harga</label>

<input
type="number"
name="harga"
value="<?php echo $m['harga']; ?>"
required>

</div>

<!-- STOK -->

<div class="form-group">

<label>Stok</label>

<input
type="number"
name="stok"
value="<?php echo $m['stok']; ?>"
required>

</div>

<!-- KATEGORI -->

<div class="form-group">

<label>Kategori</label>

<select
name="id_kategori"
required>

<?php while($k = mysqli_fetch_array($kategori)){ ?>

<option
value="<?php echo $k['id_kategori']; ?>"

<?php
if(
$k['id_kategori']
==
$m['id_kategori']
){
echo 'selected';
}
?>

>

<?php
echo $k['nama_kategori'];
?>

</option>

<?php } ?>

</select>

</div>

<!-- GAMBAR -->

<div class="form-group">

<label>Ganti Gambar</label>

<input
type="file"
name="gambar">

</div>

<!-- BUTTON -->

<div class="form-action">

<button type="submit">

Update Menu

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