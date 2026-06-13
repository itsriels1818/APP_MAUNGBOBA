<?php
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "kedai_maung_fiks"
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

