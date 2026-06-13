<?php

require_once __DIR__ . '/../../config/koneksi.php';

header('Content-Type: application/json');

$q = mysqli_query($conn,"
SELECT COUNT(*) as total
FROM pesanan
WHERE status_pesanan='menunggu'
");

$data = mysqli_fetch_assoc($q);

echo json_encode([
    'total' => (int)$data['total']
]);