<?php

include '../config/koneksi.php';

$id =
isset($_GET['id'])
? intval($_GET['id'])
: 0;

/* HAPUS */

mysqli_query($conn,"
DELETE FROM menu
WHERE id_menu='$id'
");

/* REDIRECT */

header(
"Location:../admin/menu.php?hapus=1"
);

?>