<?php

include '../config/koneksi.php';

$id =
isset($_GET['id'])
? intval($_GET['id'])
: 0;

$status =
isset($_GET['status'])
? $_GET['status']
: '';

$filter =
isset($_GET['filter'])
? $_GET['filter']
: 'semua';

/* VALIDASI */

$statusValid = [
'menunggu',
'diproses',
'selesai'
];

if(
$id > 0 &&
in_array($status,$statusValid)
){

mysqli_query($conn,"
UPDATE pesanan
SET status_pesanan='$status'
WHERE id_pesanan='$id'
");

}

/* KEMBALI */

header(
"Location:../admin/pesanan.php?status=$filter&success=1"
);

exit;

?>