<?php

session_start();

require_once __DIR__ . '/../config/koneksi.php';

/* AMBIL DATA */

$username = mysqli_real_escape_string(
    $conn,
    $_POST['username']
);

$password = md5(
    $_POST['password']
);

/* CEK USER */

$query = mysqli_query(
    $conn,
    "SELECT *
    FROM users
    WHERE username='$username'
    AND password='$password'"
);

/* JIKA DITEMUKAN */

if(mysqli_num_rows($query) > 0){

    $user = mysqli_fetch_assoc(
        $query
    );

    $_SESSION['login'] = true;

    $_SESSION['id_user'] =
    $user['id_user'];

    $_SESSION['username'] =
    $user['username'];

    $_SESSION['nama_lengkap'] =
    $user['nama_lengkap'];

    $_SESSION['role'] =
    $user['role'];

    header(
        "Location: index.php"
    );

    exit;

}

/* JIKA GAGAL */

header(
    "Location: login.php?error=1"
);

exit;

?>