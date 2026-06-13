<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';

$id_user = $_SESSION['id_user'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE id_user='$id_user'"
);

$user = mysqli_fetch_assoc($query);

$foto = !empty($user['foto'])
    ? "../assets/uploads/profil/" . $user['foto']
    : "../assets/img/default-user.png";
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pengaturan Profil Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
body{
    background:#f5f7fb;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
}

.profile-photo{
    width:130px;
    height:130px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #fff;
    box-shadow:0 4px 10px rgba(0,0,0,.15);
}
</style>

</head>
<body>

<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-gear-fill"></i>
        Pengaturan Profil
    </h2>

    <a href="index.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i>
        Dashboard
    </a>
</div>

<div class="card mb-4">
    <div class="card-body text-center">

        <img src="<?= $foto ?>" class="profile-photo mb-3">

        <h4><?= htmlspecialchars($user['nama_lengkap']) ?></h4>

        <p class="text-muted">
            <?= htmlspecialchars($user['role']) ?>
        </p>

    </div>
</div>

<div class="card mb-4">

<div class="card-header bg-primary text-white">
    Profil Admin
</div>

<div class="card-body">

<form action="proses_pengaturan.php"
      method="POST"
      enctype="multipart/form-data">

<div class="mb-3">
<label>Username</label>
<input type="text"
       name="username"
       class="form-control"
       value="<?= htmlspecialchars($user['username']) ?>"
       required>
</div>

<div class="mb-3">
<label>Nama Lengkap</label>
<input type="text"
       name="nama_lengkap"
       class="form-control"
       value="<?= htmlspecialchars($user['nama_lengkap']) ?>"
       required>
</div>

<div class="mb-3">
<label>Foto Profil</label>
<input type="file"
       name="foto"
       class="form-control">
</div>

<button type="submit"
        name="simpan_profil"
        class="btn btn-primary">
    Simpan Profil
</button>

</form>

</div>
</div>

<div class="card">

<div class="card-header bg-success text-white">
    Ubah Password
</div>

<div class="card-body">

<form action="proses_pengaturan.php"
      method="POST">

<div class="mb-3">
<label>Password Lama</label>
<input type="password"
       name="password_lama"
       class="form-control"
       required>
</div>

<div class="mb-3">
<label>Password Baru</label>
<input type="password"
       name="password_baru"
       class="form-control"
       required>
</div>

<div class="mb-3">
<label>Konfirmasi Password</label>
<input type="password"
       name="konfirmasi_password"
       class="form-control"
       required>
</div>

<button type="submit"
        name="ubah_password"
        class="btn btn-success">
    Ubah Password
</button>

</form>

</div>
</div>

</div>

</body>
</html>