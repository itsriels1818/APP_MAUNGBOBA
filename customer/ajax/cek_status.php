<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['antrian'])) {

    echo json_encode([
        'status' => 'tidak_ada'
    ]);

    exit;
}

$nomor = $_SESSION['antrian']['nomor'];

$q = mysqli_query(
    $conn,
    "SELECT status_pesanan
     FROM pesanan
     WHERE nomor_antrian='$nomor'
     LIMIT 1"
);

if (mysqli_num_rows($q) == 0) {

    unset($_SESSION['antrian']);

    echo json_encode([
        'status' => 'tidak_ada'
    ]);

    exit;
}

$data = mysqli_fetch_assoc($q);

if ($data['status_pesanan'] == 'selesai') {

    unset($_SESSION['antrian']);

    echo json_encode([
        'status' => 'selesai'
    ]);

    exit;
}

echo json_encode([
    'status' => $data['status_pesanan']
]);