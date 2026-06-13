<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';

$id_user = $_SESSION['id_user'];

if (isset($_POST['simpan_profil'])) {

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $nama_lengkap = mysqli_real_escape_string(
        $conn,
        $_POST['nama_lengkap']
    );

    mysqli_query(
        $conn,
        "UPDATE users SET
        username='$username',
        nama_lengkap='$nama_lengkap'
        WHERE id_user='$id_user'"
    );

    if (!empty($_FILES['foto']['name'])) {

        $namaFile =
            time().'_'.
            basename($_FILES['foto']['name']);

        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            "../assets/uploads/profil/".$namaFile
        );

        mysqli_query(
            $conn,
            "UPDATE users
            SET foto='$namaFile'
            WHERE id_user='$id_user'"
        );
    }

    $_SESSION['username'] = $username;
    $_SESSION['nama_lengkap'] = $nama_lengkap;

    header("Location: pengaturan.php");
    exit;
}

if (isset($_POST['ubah_password'])) {

    $password_lama = md5($_POST['password_lama']);
    $password_baru = md5($_POST['password_baru']);
    $konfirmasi = md5($_POST['konfirmasi_password']);

    $user = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT * FROM users
            WHERE id_user='$id_user'"
        )
    );

    if ($password_lama != $user['password']) {

        echo "<script>
        alert('Password lama salah');
        window.location='pengaturan.php';
        </script>";
        exit;
    }

    if ($password_baru != $konfirmasi) {

        echo "<script>
        alert('Konfirmasi password tidak cocok');
        window.location='pengaturan.php';
        </script>";
        exit;
    }

    mysqli_query(
        $conn,
        "UPDATE users
        SET password='$password_baru'
        WHERE id_user='$id_user'"
    );

    echo "<script>
    alert('Password berhasil diubah');
    window.location='pengaturan.php';
    </script>";
}