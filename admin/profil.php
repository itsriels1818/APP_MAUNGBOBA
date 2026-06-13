<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

include '../config/koneksi.php';

$username = $_SESSION['login'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>

<div class="main-content">

    <div class="welcome-box">
        <h2>Profil Admin</h2>
        <p>Kelola informasi akun administrator</p>
    </div>

    <div class="dashboard-card">

        <form action="update_profil.php" method="POST">

            <div class="mb-3">
                <label>Username</label>
                <input
                    type="text"
                    name="username"
                    class="form-control"
                    value="<?php echo $username; ?>">
            </div>

            <div class="mb-3">
                <label>Password Baru</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Kosongkan jika tidak ingin mengubah">
            </div>

            <button type="submit" class="btn btn-dark">
                Simpan Perubahan
            </button>

        </form>

    </div>

</div>

</body>
</html>